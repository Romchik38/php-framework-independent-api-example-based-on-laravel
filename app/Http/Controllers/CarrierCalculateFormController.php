<?php

namespace App\Http\Controllers;

use App\Application\CarrierService\CalculateShippingCosts\CalculateCommand;
use App\Application\CarrierService\CalculateShippingCosts\CalculateException;
use App\Application\CarrierService\CarrierService;
use App\Application\CarrierService\NoSuchCarrierException;
use App\Http\Controllers\CarrierCalculateFormController\ErrorDto;
use App\Http\Controllers\CarrierCalculateFormController\SuccessDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CarrierCalculateFormController extends Controller
{
    public function __construct(
        private readonly CarrierService $carrierService
    ) {}

    public function index()
    {
        // do not catch errors (show common 500 error page)
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
        try {
            $command = CalculateCommand::fromHash($params);
            $viewDto = $this->carrierService->calculateShippingCosts($command);
            $successDto = new SuccessDto($viewDto);

            return new JsonResponse($successDto);
        } catch (NoSuchCarrierException|InvalidArgumentException $e) {
            $errorDto = new ErrorDto($e->getMessage());

            return new JsonResponse($errorDto, 400);
        } catch (CalculateException $e) {
            // Do log if necessary.
            $errorDto = new ErrorDto('There is an error on our side, please try again later');

            return new JsonResponse($errorDto, 500);
        }
    }
}
