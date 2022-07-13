<?php

namespace Brightmilk\HtmlParser\Enum;

enum TokenType: int
{
    case T_END   = 0;
    case T_OPEN  = 1;
    case T_CLOSE = 2;
    case T_TEXT  = 3;
}
