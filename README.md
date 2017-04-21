# ketwaroo/parsedown

Package aims at extending erusev/parsedown-extra a bit to fit my purposes. These may not fit yours.

This is a work in progress.

# Differences so far:

## Special Attributes.

[Special attributes](https://michelf.ca/projects/php-markdown/extra/#spe-attr) were not handled completely. Only id, class were working. Everything else failed.

Changed the way special attributes are handled. Extra attributes other than shorthand `#id` and `.class` should be written as `name="always quoted value whether or not there are spaces". 

Example:

```html
[test link](#anchorlink){#foo .bar .fubar target="_blank" data-cow-goes="moo moo"}

now converts to

<a href="#anchorlink" id="foo" class="bar fubar" target="_blank" data-cow-goes="moo moo">test link</a>

instead of failing to

<a href="#anchorlink">test link</a>{#foo .bar .fubar target="_blank" data-cow-goes="moo moo"}

```

### Special Attributes on tables

previously an unspported element for special attributes.

```html

table | test {#fooTable .table .table-striped data-cat-goes="meow meow"}
--- | --- 
a1|a2 
b1|b2 

now converts to

<table id="fooTable" class="table table-striped" data-cat-goes="meow meow">
<thead>
<tr>
<th>table</th>
<th>test</th>
</tr>
</thead>
<tbody>
<tr>
<td>a1</td>
<td>a2</td>
</tr>
<tr>
<td>b1</td>
<td>b2</td>
</tr>
</tbody>
</table>

The special attrib tag must be on header row.

Also produces same effect..

| table | test |{#fooTable .table .table-striped data-cat-goes="meow meow"}
| ----- | ---- |
| a1    | a2   | 
| b1    | b2   |

TODO maybe add special attr per row.

```



