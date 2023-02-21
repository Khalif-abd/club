<?php

namespace App\Exceptions;


use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use GuzzleHttp\Exception\ServerException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;


use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Метод визуализации исключений.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse
    {
        if (!str_starts_with($request->path(), 'api/')) {
            return parent::render($request, $e);
        }

        $message = '';
        $exceptionClass = get_class($e);

        switch ($exceptionClass) {
            case NotFoundHttpException::class :
            case ModelNotFoundException::class :
                $statusCode = Response::HTTP_NOT_FOUND;
                $message = 'Not found';
                break;
            case 'TypeError':
                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $message = $e->getMessage() ?: 'Не корректный тип ключа';
                break;
            case MethodNotAllowedHttpException::class :
                $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
                $message = 'Данный метод не поддерживается';
                break;
            case QueryException::class :
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = 'Ошибка в работе базы данных';
                break;
            case 'BadMethodCallException':
            case ConnectionException::class :
                $statusCode = Response::HTTP_SERVICE_UNAVAILABLE;
                $message = 'Сервис недоступен';
                break;
            case HttpClientException::class :
                $statusCode = $e->getCode() ?: Response::HTTP_UNPROCESSABLE_ENTITY;
                $message = $e->getMessage();
                break;
            case AuthorizationException::class:
                $message = 'Forbidden';
                $statusCode = Response::HTTP_FORBIDDEN;
                break;
            case AuthenticationException::class:
                $message = 'Unauthorized';
                $statusCode = Response::HTTP_UNAUTHORIZED;
                break;
            case HttpResponseException::class:
                $message = $e->getMessage();
                $statusCode = $e->getStatusCode() ?: Response::HTTP_FORBIDDEN;
                break;
            case ServerException::class:
                $message = $e->getResponse()->getBody()->getContents();
                $statusCode = $e->getCode() ?: Response::HTTP_UNPROCESSABLE_ENTITY;
                break;
            case HttpException::class:
                $message = $e->getMessage();
                $statusCode = $e->getStatusCode() ?: Response::HTTP_UNPROCESSABLE_ENTITY;
                break;
            case ThrottleRequestsException::class:
                $message = 'Превышен лимит запросов';
                $statusCode = Response::HTTP_TOO_MANY_REQUESTS;
                break;
            case Exception::class:
                $message = 'Неизвестная ошибка';
                $statusCode = Response::HTTP_TOO_MANY_REQUESTS;
                break;
            default:
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = 'Неизвестная ошибка';
        }

        $response = [
            'status' => 'error'
        ];


        if (!App::isProduction()) {
            $response['exception_class'] = get_class($e);
            $response['message'] = $e->getMessage() ?: $message;
            $response['trace'] = $e->getTrace();
        } else {
            $response['message'] = $message ?: 'Неизвестная ошибка';
        }


        return response()->json(
            $response,
            $statusCode
        );
    }
}
