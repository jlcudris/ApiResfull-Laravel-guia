<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use Illuminate\Database\QueryException;

use Symfony\Component\HttpKernel\Exception\HttpException;

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
        if($exception instanceof ModelNotFoundException){
            $modelo = strtolower(class_basename ($exception->getModel() ) );
            return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id expecificado", 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse("No poses permiso para realizar esta accion ", 403);
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("No se encontro la URL especificada", 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("el metodo especificado en la peticion no es valido", 404);
        }

        if ($exception instanceof HttpException) {

            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        //aqui

        if ($exception instanceof QueryException) {

            $codigo =$exception->errorInfo[1];
            if($codigo == 1451){
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso por qu esta relacionado con algun otro',409);
            }

        }

        if(config('app.debug')){

            return parent::render($request, $exception);
        }

        return $this->errorResponse('Falla inesperada. intente luego', 500);


    }
}
