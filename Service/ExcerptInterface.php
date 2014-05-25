<?php

namespace HappyR\ExcerptBundle\Service;

/**
 * @author Tobias Nyholm
 */
interface ExcerptInterface
{
    public function getExcerpt($string, $limit = null, $tail = null);
}