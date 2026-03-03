<?php

namespace Tests\Feature\Http\Controllers;

use App\Application\CarrierService\CalculateShippingCosts\CalculateCommand;
use App\Application\CarrierService\CalculateShippingCosts\CalculateView;
use App\Http\Controllers\CarrierCalculateFormController\Dto;
use Database\Seeders\TestCarrierSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarrierCalculateFormControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Success test.
     */
    public function test_calculate_shipping_costs_success(): void
    {
        $this->seed(TestCarrierSeeder::class);

        $slugField = CalculateCommand::slugField;
        $weightField = CalculateCommand::weightField;
        $carrierSlug = 'testcarrier1';
        $weight = 10;

        $response = $this->post(
            '/api/shipping/calculate',
            [
                $weightField => $weight,
                $slugField => $carrierSlug,
            ],
            [
                'Content-Type' => 'multipart/form-data',
            ]

        );

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');

        $content = $response->json();
        $status = $content[Dto::STATUS_FIELD];
        $result = $content[Dto::RESULT_FIELD];

        $this->assertSame(Dto::SUCCESS_FIELD, $status);
        $this->assertSame($carrierSlug, $result[$slugField]);
        $this->assertSame($weight, $result[$weightField]);
        $this->assertSame('EUR', $result[CalculateView::CURRENCY_FIELD]);
        $this->assertSame($weight, $result[CalculateView::PRICE_FIELD]);
    }

    /**
     * Error test - wrong carrier slug
     */
    public function test_calculate_shipping_costs_error_slug(): void
    {
        $this->seed(TestCarrierSeeder::class);

        $slugField = CalculateCommand::slugField;
        $weightField = CalculateCommand::weightField;
        $carrierSlug = 'testcompany10';  // wrong
        $weight = 10;

        $response = $this->post(
            '/api/shipping/calculate',
            [
                $weightField => $weight,
                $slugField => $carrierSlug,
            ],
            [
                'Content-Type' => 'multipart/form-data',
            ]

        );

        $response->assertStatus(400);
        $response->assertHeader('content-type', 'application/json');

        $content = $response->json();
        $status = $content[Dto::STATUS_FIELD];

        $this->assertSame(Dto::ERROR_FIELD, $status);
    }

    /**
     * Error test - wrong weight
     */
    public function test_calculate_shipping_costs_error_weight(): void
    {
        $this->seed(TestCarrierSeeder::class);

        $slugField = CalculateCommand::slugField;
        $weightField = CalculateCommand::weightField;
        $carrierSlug = 'testcarrier1';
        $weight = 0;    // wrong

        $response = $this->post(
            '/api/shipping/calculate',
            [
                $weightField => $weight,
                $slugField => $carrierSlug,
            ],
            [
                'Content-Type' => 'multipart/form-data',
            ]

        );

        $response->assertStatus(400);
        $response->assertHeader('content-type', 'application/json');

        $content = $response->json();
        $status = $content[Dto::STATUS_FIELD];

        $this->assertSame(Dto::ERROR_FIELD, $status);
    }
}
