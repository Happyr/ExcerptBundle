HappyR ExcerptBundle
=====================

This bundle provides integration of the [URLify](https://github.com/jbroadway/urlify) library into Symfony2.
A excerpt service and twig filter is provided. This bundle is a modified version of the
[ZenstruckExcerptBundle](https://github.com/kbond/ZenstruckExcerptBundle). The ZenstruckExcerptBundle uses the
[Excerpt](https://github.com/cocur/excerpt) library.

## Installation

1. Install with composer:

    ```
    php composer.phar require happyr/excerpt-bundle
    ```

2. Enable the bundle:

    ```php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new HappyR\ExcerptBundle\HappyRExcerptBundle(),
        );
    }
    ```

## Using the service

```php

$slugifier = $this->container->get('happyr.excerpt.slugifier');
$text = $slugifier->excerpt('Hello World!');
echo $text; //prints "hello-world"
```

## Using the Twig filter

```html
{{ 'Hello World!'|excerpt }} {# hello-world #}

```

## Full Default Configuration

```yaml
happy_r_excerpt:
    twig: false #set to true to enable twig filter
```