<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A lista de inputs que nunca são armazenados na sessão durante exceções de validação.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra os callbacks de tratamento de exceções para a aplicação.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Renderiza uma exceção em uma resposta HTTP.
     *
     * Se a exceção for uma ModelNotFoundException, retorna uma resposta JSON com uma mensagem de erro e o código 404.
     * Se a exceção for uma AccessDeniedHttpException, retorna uma resposta JSON com a mensagem de erro da exceção e o código 403.
     * Caso contrário, chama o método render padrão da classe pai.
     *
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return new JsonResponse(['error' => 'Recurso não encontrado.'], 404);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return new JsonResponse(['error' => $exception->getMessage()], 403);
        }

        return parent::render($request, $exception);
    }
}
