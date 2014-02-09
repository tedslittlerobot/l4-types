L4 Types
========

> Some Utilities for managing types of related content in Laravel 4

Say you wanted to have a blog with multiple types of main content (articles, videos, image galleries, tutorials, etc.)

## Installation

Add the following to your composer.json file:

```json
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/tedslittlerobot/l4-types"
    }
],
```

Then, you can `composer require tlr/l4-types` to add this to your composer.json and download it.

You may want to add `Tlr\Types\TypeServiceProvider` to your `providers` list in `app.php`, and

```php
'TypeSet'      => 'Tlr\Types\Facades\TypeSet',
```

to your aliases array.

## Config

Add a config file at `app/config/types.php`, and set it up as below:

```php
<?php

return array(

	'types' => array(
		'default' => array(

		),
	),
);
```

This array is where you can register content types. See below for an example.
