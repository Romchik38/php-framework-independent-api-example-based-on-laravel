<?php

namespace App\Http\Controllers;

use App\Application\CarrierService\CalculateShippingCosts\CalculateCommand;
use App\Application\CarrierService\CalculateShippingCosts\CalculateException;
use App\Application\CarrierService\CarrierService;
use App\Http\Controllers\CarrierCalculateFormController\ErrorDto;
use App\Http\Controllers\CarrierCalculateFormController\SuccessDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

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

    public function calculate(Request $request): JsonResponse
    {
        $params = $request->request->all();
        $weight = (string) $params[CalculateCommand::weightField];
        $slug = (string) $params[CalculateCommand::slugField];
        try {
            
            $command = new CalculateCommand($slug, $weight);
            
            $viewDto = $this->carrierService->calculateShippingCosts($command);
            $successDto = new SuccessDto($viewDto);
            return new JsonResponse($successDto);
        } catch (CalculateException | InvalidArgumentException $e) {
            $errorDto = new ErrorDto($e->getMessage());
            return new JsonResponse($errorDto, 400);
        }
    }    
}
