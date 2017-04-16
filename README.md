# ketwaroo/parsedown

Package aims at extending erusev/parsedown-extra a bit to fit my purposes. These may not fit yours.

This is a work in progress.

# Differences so far:

## Special Attributes.

[Special attributes](https://michelf.ca/projects/php-markdown/extra/#spe-attr) were not handled completely. Only id, class and spaces weren't allowed in attribute values.

Changed the way special attributes are handled

```html
[test link](#anchorlink){#foo .bar .fubar target="_blank" data-cow-goes="moo"}

now converts to

<a href="#anchorlink" id="foo" class="bar fubar" target="_blank" data-cow-goes="moo">test link</a>

instead of failing to

<a href="#anchorlink">test link</a>{#foo .bar .fubar target="_blank" data-cow-goes="moo"}


```



