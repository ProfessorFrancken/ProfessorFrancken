<?php

declare(strict_types=1);

namespace Francken\Shared;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Whoops\Handler\HandlerInterface;

class ExceptionsHandler extends Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     */
    public function report(Throwable $e) : void
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     */
    public function render($request, Throwable $e) : Response
    {
        return parent::render($request, $e);
    }

    /**
     * Overwrite the whoopsHandler so that we can use the new ignition error handler
     */
    protected function whoopsHandler() : \Whoops\Handler\Handler
    {
        try {
            /** @var \Whoops\Handler\Handler $handler */
            $handler = app(HandlerInterface::class);

            return $handler;
        } catch (BindingResolutionException $e) {
            return parent::whoopsHandler();
        }
    }
}
