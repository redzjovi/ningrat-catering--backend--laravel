<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /*
         * We add a custom exception renderer here since this will be an api only backend.
         * So we need to convert every exception to a json response.
         */
        if ($request->ajax() || $request->wantsJson()) {
            return $this->getJsonResponse($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Get the json response for the exception.
     *
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponse($request, Exception $exception)
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json(
                [
                    'message' => 'Model Not Found.'
                ],
                Response::HTTP_NOT_FOUND
            );
        } elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => $exception->validator->getMessageBag()
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } elseif ($this->isHttpException($exception)) {
            $status = $exception->getStatusCode();
            return response()->json(
                [
                    'message' => Response::$statusTexts[$status]
                ],
                $status
            );
        } else {
            return parent::render($request, $exception);
        }
    }
}
