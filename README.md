# html-parser

Парсер HTML.

# Пример использования:

В файле `public/index.php`:

```
$text = '<div>Here is <a>a link</a> some <b>bold text</B> and <A>extra link</A>.</div>';
$tokenizer = new HtmlTokenizer($text);

$tokens = $tokenizer->getTokens();

foreach ($tokens as $token) {
    echo 'Tag name ' . $token->getName() . ' with ' . $token->getType()->name . ' type.' . PHP_EOL ;
}
```
