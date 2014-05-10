<?hh


namespace HappyR\ExcerptBundle\Service;


/**
 * Class HackExcerpt
 *
 * @author Tobias Nyholm
 *
 */
class HackExcerpt implements ExcerptInterface
{

    public function __construct($limit=300, $tail='…')
    {

    }

    public function getExcerpt($string, $limit = null, $tail = null)
    {
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

        return substr($string, 0, $cut ? $cut : $limit) . $tail;
    }
} 