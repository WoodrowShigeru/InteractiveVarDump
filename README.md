# InteractiveVarDump
An interactive alternative to PHP's native `var_dump()` function, insofar as it lets you collapse and expand the individual children.


NOTE: Does not work with some data types, i.e.:
- objects of the class `DOMDocument` due to a bug in the Reflection framework: https://bugs.php.net/bug.php?id=48527
- `RecursiveDirectoryIterator`

## Basic Usage
- `require` or `include` the file `InteractiveVarDump/functions.php` into your working environment
- call `ivd( $any_var );`
- optionally add a string: `ivd( $any_object, 'This is $any_var' );`
- alternatively, call `qvd( $any_var )` for a very quick native `var_dump` call wrapped with `‹pre›` tags.

Depending on the complexity of the variable, additional overhead controller links will appear in the head of the tree.

Link | Functionality
---- | -------------
`toggle-break inline` | Adds or removes the inline style of the values, so that they appear in the same line or in a new line.
`toggle-show public  properties` | Recursively shows or hides any public  properties.
`toggle-show private properties` | Recursively shows or hides any private properties.
`batch-collapse` | Collapse all child and grandchild objects and arrays; but not the root.
`batch-expand` | Expands all child and grandchild objects and arrays.

## Extended Usage
- call `$tree = ivd( $any_var, NULL, TRUE );` in order to get the tree as a return value instead of having it be printed.