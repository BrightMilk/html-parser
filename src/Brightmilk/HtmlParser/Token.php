<?php

namespace Brightmilk\HtmlParser;

use Brightmilk\HtmlParser\Enum\TokenType as ETokenType;

class Token
{
    private ETokenType $type;

    private string     $text;

    private ?string    $name = null;

    /**
     * @return ETokenType
     */
    public function getType(): ETokenType
    {
        return $this->type;
    }

    /**
     * @param ETokenType $type
     * @return $this
     */
    public function setType(ETokenType $type): Token
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): Token
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): Token
    {
        $this->text = $text;

        return $this;
    }
}
