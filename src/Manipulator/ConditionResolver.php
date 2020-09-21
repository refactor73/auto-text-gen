<?php

declare(strict_types=1);

namespace AutoTextGen\Manipulator;

use AutoTextGen\Context;
use AutoTextGen\ControlStructure;
use AutoTextGen\DecisionTable;

/**
 * Class ConditionResolver
 * @package AutoTextGen
 */
class ConditionResolver
{
    private DecisionTable $decisionTable;

    private Context $context;

    /**
     * ConditionResolver constructor.
     * @param DecisionTable $decisionTable
     * @param Context $context
     */
    public function __construct(
        DecisionTable $decisionTable,
        Context $context
    ) {
        $this->decisionTable = $decisionTable;
        $this->context = $context;
    }

    /**
     * @param string $pattern
     * @return string
     */
    public function __invoke(string $pattern): string
    {
        $text = $pattern;

        $found = preg_match_all('/\\[if(.*?)\\]([^\[])*\\[endif\\]/i', $pattern, $matches);

        if ($found === 0 || $found === false) {
            return $text;
        }

        foreach ($matches[0] as $match) {
            $controlStructure = $this->extractControlStructureFromString($match);

            if ($controlStructure === null) {
                continue;
            }

            $text = $this->decisionTable->conditionsAreTrue($controlStructure->conditions())
                ? str_replace($match, $controlStructure->statement(), $text)
                : str_replace($match, $controlStructure->else(), $text);
        }

        return $text;
    }

    /**
     * @param string $string
     * @return ControlStructure|null
     */
    private function extractControlStructureFromString(string $string): ?ControlStructure
    {
        $else = null;
        $found = preg_match('/^\\[if ([^\]]*)\\](.*)\\[endif\\]$/i', $string, $matches);

        if ($found === 0 ||$found === false) {
            return null;
        }

        $statement = trim($matches[2] ?? '');
        $branching = explode('[ELSE]', $statement);

        if (count($branching) === 2) {
            $statement = trim($branching[0]);
            $else = trim($branching[1]);
        }

        $conditions = explode(';', str_replace(' ', '', $matches[1] ?? ''));

        return ControlStructure::create(
            $conditions,
            $statement,
            $else
        );
    }
}
