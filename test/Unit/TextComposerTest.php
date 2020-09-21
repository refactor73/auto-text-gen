<?php

declare(strict_types=1);

namespace AutoTextGenTest\Unit;

use AutoTextGen\Context;
use AutoTextGen\DecisionTable;
use AutoTextGen\TextComposer;
use PHPUnit\Framework\TestCase;

class TextComposerTest extends TestCase
{
    public function testCompose(): void
    {
        $pattern = '{In dieser Woche|Aktuell} ist der Wert um ${trend} auf ${total} Punkte ' .
            ' [IF $isNegative] gefallen [ELSE] gestiegen [ENDIF]';

        $context = Context::fromArray([
            'trend' => 10,
            'total' => 90,
        ]);

        $decisionTable = DecisionTable::fromArray([
            'isNegative' => false,
        ]);

        $textComposer = new TextComposer($decisionTable, $context);

        $result = $textComposer->compose($pattern);

        self::assertContains(
            $result,
            [
                'In dieser Woche ist der Wert um 10 auf 90 Punkte gestiegen',
                'Aktuell ist der Wert um 10 auf 90 Punkte gestiegen',
            ]
        );
    }
}
