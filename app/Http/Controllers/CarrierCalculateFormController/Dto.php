<?php

declare(strict_types=1);

namespace App\Http\Controllers\CarrierCalculateFormController;

use JsonSerializable;

abstract class Dto implements JsonSerializable
{
    public const STATUS_FIELD = 'status';
    public const SUCCESS_FIELD = 'success';
    public const ERROR_FIELD = 'error';
    public const RESULT_FIELD = 'result';
}
