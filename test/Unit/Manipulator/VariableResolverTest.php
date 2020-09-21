<?php

declare(strict_types=1);

namespace AutoTextGenTest\Unit\Manipulator;

use AutoTextGen\Context;
use AutoTextGen\Manipulator\SynonymSpinner;
use AutoTextGen\Manipulator\VariableResolver;
use PHPUnit\Framework\TestCase;

/**
 * Class VariableResolverTest
 * @package AutoTextGenTest\Unit\Manipulator
 */
class VariableResolverTest extends TestCase
{
    public function testVariableResolver(): void
    {
        $pattern = 'Aktuell ist die Zahl um ${points} Punkte gestiegen';

        $context = Context::fromArray([
            'points' => 10,
        ]);

        $varResolver = new VariableResolver($context);
        $result = $varResolver($pattern);

        self::assertSame(
            'Aktuell ist die Zahl um 10 Punkte gestiegen',
            $result
        );
    }
}
