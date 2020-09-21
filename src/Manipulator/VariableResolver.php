<?php

declare(strict_types=1);

namespace AutoTextGen\Manipulator;

use AutoTextGen\Context;

class VariableResolver
{
    private Context $context;

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function __invoke($pattern): string
    {
        $text = $pattern;
        $n = 0;
        $found = preg_match_all('/\$\{([\S]{1,})\}/i', $pattern, $matches);

        if ($found === 0 || $found === false) {
            return $text;
        }

        foreach ($matches[0] as $match) {
            $varName = $matches[1][$n];
            $text = str_replace($match, $this->context->get($varName), $text);

            $n++;
        }

        return $text;
    }
}
