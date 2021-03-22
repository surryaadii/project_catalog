<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['token_expired'], $exception->getStatusCode());
            } else if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['token_invalid'], $exception->getStatusCode());
            } else {
                return response()->json(["UNAUTHORIZED_REQUEST"], 401);
            }
        }

        //check if exception is an instance of ModelNotFoundException.
        //or NotFoundHttpException
        if ($exception instanceof ModelNotFoundException or $exception instanceof NotFoundHttpException) {
            // ajax 404 json feedback
            if ($request->ajax()) {
                return response()->json(['error' => 'Not Found'], 404);
            }
            ///dd($exception);
            // normal 404 view page feedback
            return response()->view('errors.404', [], 404);
        }
    

        return parent::render($request, $exception);
    }

        /**
         * Convert an authentication exception into an unauthenticated response.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Illuminate\Auth\AuthenticationException  $exception
         * @return \Illuminate\Http\Response
         */
        protected function unauthenticated($request, AuthenticationException $exception)
        {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('admin.login');
        }
}
