<?php

declare(strict_types=1);

namespace AutoTextGen\Manipulator;

use Exception;

/**
 * Class SynonymSpinner
 * @package AutoTextGen
 */
class SynonymSpinner
{
    /** @var string  */
    private const VARIATION_DELIMITER = '|';

    /**
     * @param string $pattern
     * @return string
     * @throws Exception
     */
    public function __invoke(string $pattern): string
    {
        $text = $pattern;
        $n = 0;

        $found = preg_match_all('/\\{(.*?)\\}/S', $pattern, $matches);

        if ($found === 0 || $found === false) {
            return $text;
        }

        foreach ($matches[1] as $match) {
            $variations = explode(self::VARIATION_DELIMITER, $match);

            $text = str_replace($matches[0][$n], $variations[random_int(0, count($variations) - 1)], $text);

            $n++;
        }

        return $text;
    }
}
