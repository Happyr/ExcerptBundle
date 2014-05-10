<?php

namespace HappyR\ExcerptBundle\Service;

/**
 * Class ExcerptInterface
 *
 * @author Tobias Nyholm
 *
 */
interface ExcerptInterface
{
    public function __construct($limit=300, $tail='…');

    public function getExcerpt($string, $limit = null, $tail = null);
}