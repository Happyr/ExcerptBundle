<?hh

namespace HappyR\ExcerptBundle\Service;

/*
 * Create a shape representing a heading. This is basically
 * just an array but by defining a shape we make sure
 * each value exist.
 */
type Heading = shape(
  'nr' => int,
  'full' => string,
  'content' => string,
  'attributes' => string,
);

/**
 * Class HackExcerpt
 *
 * @author Tobias Nyholm
 *
 */
class HackExcerpt implements ExcerptInterface
{
    /**
     * This is a new way of declaring private variables and a constructor at the same time
     */
    public function __construct(
      private int $limit = 300,
      private string $tail = '…'
    ) {
    }

    /**
     * Get an excerpt for $text.
     *
     * Since we are implementing ExcerptInterface we can not use declare this function like the follwing row. We have to use "mixed"...
     *    public function getExcerpt(string $text, int $limit=null, string $tail=null): string
     *
     *
     * @param mixed $text
     * @param mixed $limit
     * @param mixed $tail
     *
     */
    public function getExcerpt(mixed $text, mixed $limit=null, mixed $tail=null): string
    {
        $this->getDefaults($limit, $tail);

        if (strlen($text)>$limit) {
            //make sure we don't exceed the limit
            $tooShortText = substr($text, 0, $limit);
            $lengthNoTags = strlen(strip_tags($tooShortText));
            $text=substr($text, 0, $limit + ($limit-$lengthNoTags));

            //don't cut a word
            $text = substr($text, 0, strrpos($text, ' ')).$tail;
        }

        $text=$this->stripHtml($text);
        $text=$this->closeHtmlTags($text);
        $text=$this->convertHeadings($text);

        return $text;
    }

    /**
     * Get the default values if not set
     *
     * @param int $limit passed by refrence (&) and null vallues are allowed (?)
     * @param string $$tail passed by refrence (&) and null vallues are allowed (?)
     *
     * @return void
     */
    private function getDefaults(?int &$limit, ?string &$tail): void
    {
        $limit = $limit?:$this->limit;
        $tail = $tail?:$this->tail;
    }

    /**
     * Convert all <h*> to <h3 class="something">
     *
     * @param string $text
     *
     * @return string $text
     */
    private function convertHeadings(string $text): string
    {
        $headings=$this->findHeadings($text);

        //die("<pre>".print_r($headings,true));

        foreach ($headings as $h) {
            //make sure we dont use h1 and h2
            $h['nr']=$h['nr']<3?3:$h['nr'];

            //We know $h is a Heading (shape) so we can access these key without checking if the exists.
            $replacement=sprintf('<h%d class="excerpt-heading" %s>%s</h%d>', $h['nr'], $h['attributes'], $h['content'], $h['nr']);
            $text=str_replace($h['full'], $replacement, $text);
        }

        return $text;
    }

    /**
     * Return all headings as a Map with keys "full", "attributes", "nr" and "content".
     * The headings Map is in a Vector
     *
     * @param string $text
     *
     * @return Vector<Heading>
     */
    private function findHeadings(string $text): Vector<Heading>
    {
        //create an empty vector
        $headings = Vector {};
        if (!preg_match_all('|<h([1-9])([^>]*)?>(.*?)</h[1-9]>|sim', $text, $matches)) {
            //we could not find any headings
            return $headings;
        }

        //Create a map for each heading and put it to a vector
        foreach ($matches[0] as $i => $full) {
            $headings->add( shape("full"=>$full, "attributes"=>$matches[2][$i], "content"=>$matches[3][$i], "nr"=>$matches[1][$i]));
        }

        return $headings;
    }



    /************************************************
     ************************************************
     *
     * The following function is not interesting
     * to study if you want to learn Hack.
     *
     *************************************************
     ************************************************/

    /**
     * Strip all HTML but i, p, b, strong, em, a and headings.
     *
     * @param string $text
     *
     * @return string
     */
    private function stripHtml(string $text): string
    {
        //we want to strip table and lists contents
        $text = preg_replace('|<table.*?</table>|sim', '', $text);
        $text = preg_replace('|<ul.*</ul>|sim', '', $text);
        $text = preg_replace('|<ol.*</ol>|sim', '', $text);

        return strip_tags($text, '<i><p><b><strong><em><a><h1><h2><h3><h4><h5><h6>');
    }

    /**
     * Close all open HTML tags
     *
     * @Author alexn @ stackoverflow.com (http://stackoverflow.com/questions/3810230/php-how-to-close-open-html-tag-in-a-string)
     *
     * @param string $text
     *
     * @return string
     */
    private function closeHtmlTags(string $text): string
    {
        /* Tidy is not supported in HHVM jet
        $tidy = new \tidy;
        return $tidy->repairString($str, array(
                'output-xml' => true,
                'input-xml' => true
            ),'utf8');
        */

        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $text, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $text, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $text;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $text .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }

        return $text;
    }
} 
