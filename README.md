HappyR ExcerptBundle
=====================


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
{{ '<p>Hello World Foobar!</p>'|excerpt(17) }} {# <p>Hello World...</p> #}

```

## Full Default Configuration

```yaml
happy_r_excerpt:
    tail: '...'
    length: 300
```