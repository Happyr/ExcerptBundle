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
    public function getExcerpt($string, $limit = null, $tail = null);
}