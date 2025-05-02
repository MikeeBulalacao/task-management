<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Exception $exception, Request $request) {
            if ($request->is('api/*')) {
                logger()
                    ->error(
                        sprintf('%s: %s', __METHOD__, $exception->getMessage()),
                        [
                            'trace' => $exception->getTraceAsString(),
                            'request' => $request->all(),
                        ]
                    );

                $code = $exception instanceof ValidationException
                    ? Response::HTTP_UNPROCESSABLE_ENTITY
                    : Response::HTTP_INTERNAL_SERVER_ERROR;

                return response()->json([
                    'status' => false,
                    'message' => $exception->getMessage(),
                ], $code);
            }
        });
    }
}
