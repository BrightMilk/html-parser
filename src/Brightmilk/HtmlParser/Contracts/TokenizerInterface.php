<?php

namespace Brightmilk\HtmlParser\Contracts;


use Brightmilk\HtmlParser\TokenList;

interface TokenizerInterface
{
    /**
     * Получение токенов.
     *
     * @return TokenList
     */
    public function getTokens(): TokenList;
}
