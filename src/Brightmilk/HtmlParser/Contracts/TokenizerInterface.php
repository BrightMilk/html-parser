<?php

namespace Brightmilk\HtmlParser\Contracts;


interface TokenizerInterface
{
    /**
     * Получение токенов.
     *
     * @return void
     */
    public function tokenize(): void;
}
