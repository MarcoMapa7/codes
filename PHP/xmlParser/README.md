# CHANGELOG

2017-09-17. *Breaking change:* the `xml_parse_into_array()` method of the `Parser` class
has been renamed to `xmlParseIntoArray()` according to PHP-FIG's PSR.

# ABOUT

## What `Xmtk` is?

### xml parser

`Xmtk` is a wrapper around the `xml_parse_into_struct()` function.
It parses XML strings into the structs using the above function,
but then transforms its result into easy-to-handle array hierarchies.
Please, see example 1 to get the difference.

### xml writer

The planned date of `\Xmtk\Writer` publication is the 23rd of October, 2017.
It will write hierarchical arrays to XML files.
In other words `Writer` aimed to do the reverse work of `Parser`.
See example 2.

### example 1

This example shows the difference between the result.
Look at the listing 1. It is the input XML.
Listing 2 shows what result the `xml_parse_into_struct()` will return.
And, finally, listing 3 is the result of `\Xmtk\Parser` work.

### example 2

`\Xmtk\Writer` will convert the arrays looking like in the listing 3 below
into XML string like shown in the listing 1.

### listing 1 (input xml)

```xml
<bike>
	<wheel>front</wheel>
	<wheel>rear</wheel>
	<chain>
		<length>1</length>
	</chain>
</bike>
```

### listing 2 (php function)

```php
Array
(
    [0] => Array
        (
            [tag] => bike
            [type] => open
            [level] => 1
            [value] => 
	
        )

    [1] => Array
        (
            [tag] => wheel
            [type] => complete
            [level] => 2
            [value] => front
        )

    [2] => Array
        (
            [tag] => bike
            [value] => 
	
            [type] => cdata
            [level] => 1
        )

    [3] => Array
        (
            [tag] => wheel
            [type] => complete
            [level] => 2
            [value] => rear
        )

    [4] => Array
        (
            [tag] => bike
            [value] => 
	
            [type] => cdata
            [level] => 1
        )

    [5] => Array
        (
            [tag] => chain
            [type] => open
            [level] => 2
            [value] => 
		
        )

    [6] => Array
        (
            [tag] => length
            [type] => complete
            [level] => 3
            [value] => 1
        )

    [7] => Array
        (
            [tag] => chain
            [value] => 
	
            [type] => cdata
            [level] => 2
        )

    [8] => Array
        (
            [tag] => chain
            [type] => close
            [level] => 2
        )

    [9] => Array
        (
            [tag] => bike
            [value] => 

            [type] => cdata
            [level] => 1
        )

    [10] => Array
        (
            [tag] => bike
            [type] => close
            [level] => 1
        )

)
```

### listing 3 (parser wrapper)

```php
Array
(
    [bike] => Array
        (
            [wheel] => Array
                (
                    [0] => front
                    [1] => rear
                )

            [chain] => Array
                (
                    [length] => 1
                )

        )

)
```

## What `Xmtk` stands for?

`Xmtk` stands for eXtensible Markup Tool-Kit.
Thanks for your interest.

# USAGE

## Setup

```bash
composer require xmtk/xmtk
```

## `\Xmtk\Parser`

### php

```php
#!/usr/local/bin/php
<?php
require_once __DIR__.'/vendor/autoload.php';

$parser = new \Xmtk\Parser;

$xml = '<bike>
	<wheels>
		<wheel>The front one</wheel>
		<wheel>The rear one</wheel>
	</wheels>
	<chain>
		<count>191</count>
	</chain>
</bike>';

$result = $parser->xmlParseIntoArray($xml);
print_r($result);

?>
```

### output

```php
Array
(
    [bike] => Array
        (
            [wheels] => Array
                (
                    [wheel] => Array
                        (
                            [0] => The front one
                            [1] => The rear one
                        )

                )

            [chain] => Array
                (
                    [count] => 191
                )

        )

)
```

## `\Xmtk\Writer`

The `Writer` is not implemented itself yet. What do you want? I have no sample.

## IMPORTANT NOTES

## arrays

The `\Xmtk\Parser` treats repeating tags placed on the same level as arrays.
This means that if you have two or more `<bar/>` tags inside the `<foo/>` node,
then the array for the `foo` tag will have child array `bar` indexed by numbers.
Look at the `<wheel/>` tags in the listing 1 and how they were processed by
the `\Xmtk\Parser` in the listing 3.

## KNOWN ISSUES

### attributes

All we love XML attributes.
But support of this important XML specification part is not implemented yet.
Contribute if you see that `Xmtk` is cool!

# DEVELOPMENT

## Tools

- PL: Xmtk written in the PHP programming language.
- IDE: Not used (no projects like `nbproject/`).

### composer

Composer is used as an application level package manager.
You may want to install Composer to your system for more convenient development process.
For FreeBSD the command to setup Composer system-widely will look like the next one.
```bash
sudo pkg install php-composer
```

