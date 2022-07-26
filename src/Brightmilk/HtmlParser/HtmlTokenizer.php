<?php

namespace Brightmilk\HtmlParser;

use Brightmilk\HtmlParser\Contracts\TokenizerInterface as ITokenizer;
use Brightmilk\HtmlParser\Enum\TokenType as ETokenType;


class HtmlTokenizer implements ITokenizer
{
    private const
        HTML_TAG_REGEX      = "/<\/?+\w[^>]*>/i",
        HTML_OPEN_CLOSE_TAG = '/^<(\\/?+)([-_a-zA-Z0-9]++)([^>]*+)>$/'
    ;

    private TokenList $_tokens;

    /**
     * @param string $text Входной текст.
     */
    public function __construct(private readonly string $text) {
        $this->_tokens = new TokenList();
    }

    /**
     * @inheritDoc
     */
    public function getTokens(): TokenList
    {
        if ($this->_tokens->count() === 0) {
            $this->tokenize();
        }

        return $this->_tokens;
    }

    /**
     * Процесс токенизации входных данных.
     *
     * @return void
     */
    private function tokenize(): void
    {
        $matches = [];

        $currentPosition = 0;

        while (preg_match(self::HTML_TAG_REGEX, $this->text, $matches, PREG_OFFSET_CAPTURE, $currentPosition) === 1) {
            $match = $matches[0][0];
            $lastPosition = $matches[0][1];

            if  ($lastPosition > $currentPosition) {
                $this->unmatched(substr($this->text, $currentPosition, $lastPosition - $currentPosition));
            }

            $this->matched($match);

            $currentPosition = $lastPosition + strlen($match);

            if ($currentPosition == $lastPosition) {
                throw new \LogicException('Parse pattern should not allow empty string');
            }
        }

        if ($currentPosition != strlen($this->text)) {
            $this->unmatched(substr($this->text, $currentPosition));
        }

        $this->_tokens->addToken(
            (new Token())->setType(ETokenType::T_END)
        );
    }

    /**
     * Обработка, если найдено совпадение с тегом.
     *
     * @param string $text
     * @return void
     */
    private function matched(string $text): void
    {
        $matches = [];

        if (preg_match(self::HTML_OPEN_CLOSE_TAG, $text, $matches) !== 1) {
            throw new \LogicException('Tag pattern mismatch on \'' . $text . '\'');
        }

        $this->_tokens->addToken(
            (new Token())
                ->setType((empty($matches[1])) ? ETokenType::T_OPEN : ETokenType::T_CLOSE)
                ->setName($matches[2])
                ->setText($text)
        );
    }

    /**
     * Обработка, если найдено совпадение с содержимым тега.
     *
     * @param string $text
     * @return void
     */
    private function unmatched(string $text): void
    {
        $this->_tokens->addToken(
            (new Token())
                ->setType(ETokenType::T_TEXT)
                ->setText($text)
        );
    }
}
