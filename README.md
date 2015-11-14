# html-to-wiki(media)
Convert a simple HTML file to WikiMedia format. The original purpose is a fast converter from Word exported HTML document. 

## Supported

```
* inline formatting as preformatted text: <i>, <b>, <strong>, <span>
* links <a>
* block elements: <div>, <p>
* list elements: <li>
* heading elements: <h1>, <h2>, ..., <h6>
* separators: <br>, <hr>
```

## Unsupported

```
* images
* sublist (two or more depth listing)
* definition list
* indent text
* mixture of different types of list
* apply <nowiki> tag where content match with wiki control characters
* all style attributes skipped
```

# Example
```php
require_once 'html-to-wiki/class.html-to-wiki.php';
$converter = new HtmlToWiki();
$wiki = $converter -> toWiki($html);
```