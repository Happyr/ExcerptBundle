<?php

namespace HappyR\ExcerptBundle\Twig;

/**
 * Class ExcerptExtension
 *
 * A twig extension to create an excerpt from a piece of text
 */
class ExcerptExtension extends \Twig_Extension
{
    /**
     * @var ExcerptInterface excerptService
     *
     */
    private $excerptService;

    /**
     * @param ExcerptInterface $excerptService
     */
    public function __construct(ExcerptInterface $excerptService)
    {
        $this->excerptService = $excerptService;
    }

    /**
     * @inherit
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('excerpt', array($this->excerptService, 'getExcerpt')),
        );
    }

    /**
     * @inherit
     *
     * @return string
     */
    public function getName()
    {
        return 'happyr_excerpt_extension';
    }
}
