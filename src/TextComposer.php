<?php

declare(strict_types=1);

namespace AutoTextGen;

use AutoTextGen\Manipulator\ConditionResolver;
use AutoTextGen\Manipulator\SynonymSpinner;
use AutoTextGen\Manipulator\VariableResolver;
use Exception;

class TextComposer
{
    private ConditionResolver $conditionResolver;

    private SynonymSpinner $synonymSpinner;

    private VariableResolver $variableResolver;

    private DecisionTable $decisionTable;

    /**
     * TextComposer constructor.
     * @param DecisionTable $decisionTable
     * @param Context $context
     */
    public function __construct(DecisionTable $decisionTable, Context $context)
    {
        $this->conditionResolver = new ConditionResolver($decisionTable, $context);
        $this->synonymSpinner = new SynonymSpinner();
        $this->variableResolver = new VariableResolver($context);
        $this->decisionTable = $decisionTable;
    }

    /**
     * @param string $pattern
     * @return string
     * @throws Exception
     */
    public function compose(string $pattern): string
    {
        $pattern = ($this->variableResolver)($pattern);
        $pattern = ($this->conditionResolver)($pattern);
        $pattern = ($this->synonymSpinner)($pattern);

        return preg_replace('/[ ]{2,}/', ' ', $pattern);
    }

    /**
     * @return DecisionTable
     */
    public function decisionTable(): DecisionTable
    {
        return $this->decisionTable;
    }
}
