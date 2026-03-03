<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\VO;

use App\Domain\Carrier\VO\Weight;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class WeightTest extends TestCase
{
    public function test_zero_weight(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Weight(0);
    }

    public function test_negative_weight(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Weight(-1);
    }
}
