# InteractiveVarDump
An interactive alternative to (or enhancement of) PHP's native `var_dump()` function.


NOTE: Does not work with some data types, i.e.:
- objects of the class "DOMDocument" due to a bug in the Reflection framework: https://bugs.php.net/bug.php?id=48527
- RecursiveDirectoryIterator

## How to use
- `require` or `include` "InteractiveVarDump/functions.php" into your working environment
- call `ivd( $any_object );`
- optionally add a string: `ivd( $any_object, 'This is $any_object' );`
