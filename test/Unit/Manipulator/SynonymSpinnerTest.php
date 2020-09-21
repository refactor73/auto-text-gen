<?php

declare(strict_types=1);

namespace AutoTextGenTest\Unit\Manipulator;

use AutoTextGen\Manipulator\SynonymSpinner;
use PHPUnit\Framework\TestCase;

/**
 * Class SynonymSpinnerTest
 * @package AutoTextGenTest\Unit
 */
class SynonymSpinnerTest extends TestCase
{
    public function testSpin(): void
    {
        $pattern = '{In dieser Woche|Aktuell} ist {der Wert|die Zahl|die Marke} um 10 Punkte gestiegen';

        $textSpinner = new SynonymSpinner();
        $result = $textSpinner($pattern);

        self::assertContains(
            $result,
            [
                'In dieser Woche ist der Wert um 10 Punkte gestiegen',
                'In dieser Woche ist die Zahl um 10 Punkte gestiegen',
                'In dieser Woche ist die Marke um 10 Punkte gestiegen',
                'Aktuell ist der Wert um 10 Punkte gestiegen',
                'Aktuell ist die Zahl um 10 Punkte gestiegen',
                'Aktuell ist die Marke um 10 Punkte gestiegen',
            ]
        );
    }
}
