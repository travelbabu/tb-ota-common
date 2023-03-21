<?php

namespace SYSOTEL\OTA\Common\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use SYSOTEL\OTA\Common\Helpers\Traits\RequestDefaultValuesTrait;

abstract class BaseRequest extends FormRequest
{
    use RequestDefaultValuesTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
