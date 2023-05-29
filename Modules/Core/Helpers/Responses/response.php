<?php

use Modules\Core\Helpers\Responses\ApiResponse;
use Illuminate\Contracts\Container\BindingResolutionException;

if (!function_exists("apiResponse")) {
    /**
     * @return ApiResponse
     * @throws BindingResolutionException
     */
    function apiResponse(): ApiResponse
    {
        return app(ApiResponse::class);
    }
}
