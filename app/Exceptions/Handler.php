<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
  use ApiResponser;
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
     * @throws \Exception
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
    public function render($request, Throwable $e)
    {
      if($e instanceof ValidationException) {
        return $this->convertValidationExceptionToResponse($e, $request);
      }
      elseif($e instanceof ModelNotFoundException){
        $name = class_basename($e->getModel());   //class_basename zeby nie bylo namespace w nazwie (App\User)
        return $this->errorResponse("{$name} does not exist", 404);
      }
      elseif($e instanceof AuthenticationException) {
        return $this->unauthenticated($request, $e);
      }
      elseif ($e instanceof AuthorizationException) {
        return $this->errorResponse($e->getMessage(), 403);
      }
      elseif ($e instanceof SuspiciousOperationException || $e instanceof NotFoundHttpException) {
        return $this->errorResponse('Invalid Url', 404);
      }
      elseif ($e instanceof MethodNotAllowedException) {
        return $this->errorResponse('Method not allowed', 405);
      }
      elseif ($this->isHttpException($e)) {
        return $this->errorResponse($e->getMessage(), $e->getStatusCode());
      }
      elseif($e instanceof QueryException) {
        $code = $e->errorInfo[1];
        if($code == 1451) { //delete resource error
          return $this->errorResponse('Cannot remove this resource', 409);
        }
        return $this->errorResponse('Database error', 500);
      }


      if (info('app.debug')) {
        return $this->errorResponse('Internal server error', 500);
      }

      return parent::render($request, $e);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {

        return $this->invalidJson($request, $e);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse("unauthenticated", 422);
    }
}
