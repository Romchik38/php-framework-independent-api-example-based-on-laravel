<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Persist\Carrier;

use App\Domain\Carrier\VO\Slug;
use App\Domain\Carrier\VO\Weight;
use App\Infrastructure\Persist\Carrier\CarrierRepositoryUsesBuilder;
use Database\Seeders\TestCarrierSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarrierRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testList(): void
    {
        $this->seed(TestCarrierSeeder::class);
        $repository = new CarrierRepositoryUsesBuilder();

        $result = $repository->list();
        $this->assertSame(1, count($result));
    }

    public function testFindCarrierBySlug(): void
    {
        $this->seed(TestCarrierSeeder::class);
        $repository = new CarrierRepositoryUsesBuilder();


        $slug = new Slug('testcarrier1');
        $carrier = $repository->findCarrierBySlug($slug);
        $this->assertSame('TestCarrier1', $carrier->name->value);
        $this->assertSame('testcarrier1', $carrier->slug->value);
        $price = $carrier->calculateShippingPriceByWeight(new Weight(10.5));
        $this->assertSame(10.5, $price->value);
    }


}
