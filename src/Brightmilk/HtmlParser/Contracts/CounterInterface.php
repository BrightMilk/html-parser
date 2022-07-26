<?php

namespace Brightmilk\HtmlParser\Contracts;

interface CounterInterface
{
    /**
     * Получение счетчиков.
     *
     * @return array
     */
    public function getCounts(): array;
}
