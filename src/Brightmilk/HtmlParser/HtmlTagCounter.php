<?php

namespace Brightmilk\HtmlParser;

use Brightmilk\HtmlParser\Contracts\CounterInterface as ICounter;
use Brightmilk\HtmlParser\Enum\TokenType;

class HtmlTagCounter implements ICounter
{
    /**
     * @var array|null
     */
    private ?array $tags = null;

    public function __construct(
        private readonly TokenList $tokenList
    ) {}

    /**
     * @return array
     */
    public function getCounts(): array
    {
        if ($this->tags === null) {
            $this->parse();
        }

        return $this->tags;
    }

    private function parse()
    {
        $this->tags = [];

        foreach ($this->tokenList as $token) {
            if ($token->getType() === TokenType::T_OPEN) {
                $this->increaseCounter(strtolower($token->getName()));
            }
        }
    }

    /**
     * Проверяет, существует ли счетчик данного тега.
     *
     * @param string $tagName Имя тега.
     * @return bool
     */
    private function tagExists(string $tagName): bool
    {
        return array_key_exists($tagName, $this->tags);
    }

    /**
     * Установка счетчика тега.
     *
     * @param string $tagName Имя тега.
     * @return void
     */
    private function setTag(string $tagName): void
    {
        $this->tags[$tagName] = 0;
    }

    /**
     * Увеличение счетчика тега.
     *
     * @param string $tagName Имя тега.
     * @return void
     */
    private function increaseCounter(string $tagName): void
    {
        if (!$this->tagExists($tagName)) {
            $this->setTag($tagName);
        }

        $this->tags[$tagName]++;
    }
}
