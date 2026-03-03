<?php

namespace App\Http\Controllers;

use App\Application\CarrierService\CalculateShippingCosts\CalculateCommand;
use App\Application\CarrierService\CarrierService;

class CarrierCalculateFormController extends Controller
{
    public function __construct(
        private readonly CarrierService $carrierService
    ) {
    }

    public function index()
    {
        $carriers = $this->carrierService->list();
        
        return view('calculate', [
            'carriers' => $carriers,
            'carrier_slug_field' => CalculateCommand::slugField,
            'carrier_weight_field' => CalculateCommand::weightField,            
        ]);
    }

}
