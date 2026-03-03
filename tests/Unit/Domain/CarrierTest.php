<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\Carrier\Carrier;
use App\Domain\Carrier\VO\Name;
use App\Domain\Carrier\VO\Price;
use App\Domain\Carrier\VO\Slug;
use App\Domain\Carrier\VO\Weight;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Domain\Helpers\CarrierCalculator;

class CarrierTest extends TestCase
{
    public function test_calculate_shipping_price_by_weight(): void
    {
        $name = new Name('Carrier1');
        $slug = new Slug('carrier1');
        $carrier = new Carrier(
            $name,
            $slug,
            new CarrierCalculator(new Price(1.0))
        );

        $weight = new Weight(10);
        $calculatedPrice = $carrier->calculateShippingPriceByWeight($weight);
        $this->assertSame(1.0, $calculatedPrice->value);
    }
}
