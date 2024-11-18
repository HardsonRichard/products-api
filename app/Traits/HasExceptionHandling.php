<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

trait HasExceptionHandling
{
    public function handleExceptions(Exception $e)
    {
        if ($e instanceof ValidationException) {

            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->errors(),
                'code' => $e->getCode(),
            ], 422);
        } elseif ($e instanceof ModelNotFoundException) {

            return response()->json([
                'message' => $e->getMessage(),
                'error' => 'requested resource not found',
                'code' => $e->getCode(),
            ], 404);
        } else {

            return response()->json([
                'message' => $e->getMessage(),
                'error' => 'something went wrong',
                'code' => $e->getCode(),
            ], 500);
        }
    }
}