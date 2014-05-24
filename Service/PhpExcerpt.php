<?php

namespace HappyR\ExcerptBundle\Service;

/**
 * @author Rickard Andersson
 * @author Tobias Nyholm
 */
class PhpExcerpt implements ExcerptInterface
{
    /**
     * @var int limit
     */
    private $limit;

    /**
     * @var string tail
     */
    private $tail;

    /**
     * @param integer $limit
     * @param string $tail
     */
    public function __construct($limit = 300, $tail = '…')
    {
        $this->limit = $limit;

        $this->tail = $tail;
    }

    /**
     *
     *
     * @param $string
     * @param int|null $limit
     * @param string|null $tail
     *
     * @return string
     */
    public function getExcerpt($string, $limit=null, $tail=null)
    {
        // add default values if not set
        $limit = $limit?:$this->limit;
        $tail = $tail?:$this->tail;

        $string = strip_tags($string);
        $length = strlen($string);

        if ($length <= $limit) {
            return $string;
        }

        $cut = $limit;

        // Move backwards to find the closest space
        while ($cut && substr($string, $cut, 1) !== ' ') {
            $cut--;
        }

        // No space found, move forward instead
        if (!$cut) {
            $cut = $limit;

            while ($cut < $length && substr($string, $cut, 1) !== ' ') {
                $cut++;
            }

            // If the end was reached, just cut it
            if ($cut === $length) {
                $cut = false;
            }
        }

        return substr($string, 0, $cut ? $cut : $limit).$tail;
    }
} 