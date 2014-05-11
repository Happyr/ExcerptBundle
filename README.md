HappyR Excerpt Bundle
=====================

The purpose of this is to try Hack programming language. This is not the fastest or the most elegant way
of programming. But it is a good bundle to show in a demo. 

The Excerpt Bundle takes an excerpt from a HTML string. We make sure to return valid HTML and we do not break words. 

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


## Using the Twig filter

```html
{{ '<p>Hello World Foobar!</p>'|excerpt(17) }} 
{# <p>Hello World...</p> #}

```

## Full Default Configuration

```yaml
happy_r_excerpt:
    tail: '...'
    length: 300
```
