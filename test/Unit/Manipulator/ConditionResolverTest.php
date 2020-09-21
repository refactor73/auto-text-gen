<?php

declare(strict_types=1);

namespace AutoTextGenTest\Unit\Manipulator;

use AutoTextGen\Context;
use AutoTextGen\Manipulator\ConditionResolver;
use AutoTextGen\DecisionTable;
use PHPUnit\Framework\TestCase;

/**
 * Class ConditionResolverTest
 * @package AutoTextGenTest\Unit
 */
class ConditionResolverTest extends TestCase
{
    public function testMultipleConditions(): void
    {
        $pattern = 'In einer [IF $isPositive] guten [ENDIF] Woche [IF $isPast] gab [ELSE] gibt [ENDIF] es 10 Punkte';

        $context = new Context([]);

        $decisionTable = new DecisionTable([
            'isPositive' => true,
            'isPast' => true,
        ]);

        $resolver = new ConditionResolver($decisionTable, $context);

        $result = $resolver($pattern);

        self::assertSame(
            'In einer guten Woche gab es 10 Punkte',
            $result
        );
    }

    public function testTrueCondition(): void
    {
        $pattern = 'In einer [IF $isPositive] guten [ENDIF] Woche gibt es 10 Punkte';

        $context = new Context([]);

        $decisionTable = new DecisionTable([
            'isPositive' => true,
        ]);

        $resolver = new ConditionResolver($decisionTable, $context);

        $result = $resolver($pattern);

        self::assertSame(
            'In einer guten Woche gibt es 10 Punkte',
            $result
        );
    }

    public function testTrueElseCondition(): void
    {
        $pattern = 'In dieser Woche ist der Wert um 10 Punkte [IF $isNegative] gefallen [ELSE] gestiegen [ENDIF]';

        $context = new Context([]);

        $decisionTable = new DecisionTable([
            'isNegative' => true,
        ]);

        $resolver = new ConditionResolver($decisionTable, $context);

        $result = $resolver($pattern);

        self::assertSame(
            'In dieser Woche ist der Wert um 10 Punkte gefallen',
            $result
        );
    }

    public function testFalseElseCondition(): void
    {
        $pattern = 'In dieser Woche ist der Wert um 10 Punkte [IF $isNegative] gefallen [ELSE] gestiegen [ENDIF]';

        $context = new Context([]);

        $decisionTable = new DecisionTable([
            'isNegative' => false,
        ]);

        $resolver = new ConditionResolver($decisionTable, $context);

        $result = $resolver($pattern);

        self::assertSame(
            'In dieser Woche ist der Wert um 10 Punkte gestiegen',
            $result
        );
    }

    public function testTrueAndCondition(): void
    {
        $pattern = 'Der Wert ist [IF $decision1;$decision2] gestiegen [ELSE] gefallen [ENDIF]';

        $context = new Context([]);

        $decisionTable = new DecisionTable([
            'decision1' => true,
            'decision2' => true,
        ]);

        $resolver = new ConditionResolver($decisionTable, $context);

        $result = $resolver($pattern);

        self::assertSame(
            'Der Wert ist gestiegen',
            $result
        );
    }

    public function testFalseAndCondition(): void
    {
        $pattern = 'Der Wert ist [IF $decision1;$decision2] gestiegen [ELSE] gefallen [ENDIF]';

        $context = new Context([]);

        $decisionTable = new DecisionTable([
            'decision1' => true,
            'decision2' => false,
        ]);

        $resolver = new ConditionResolver($decisionTable, $context);

        $result = $resolver($pattern);

        self::assertSame(
            'Der Wert ist gefallen',
            $result
        );
    }
}
