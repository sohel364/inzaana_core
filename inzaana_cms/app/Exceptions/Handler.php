<?php

namespace Inzaana\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Log;
use PDOException;
use QueryException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
            Log::critical('[Inzaana][' . $e->getMessage() . "] db model problem.");
            return redirect()->back();
        }
        if ($e instanceof PDOException) {
            $errorMessage = 'Something went wrong while connecting database. Please contact your server administrator.';
            Log::critical('[Inzaana][' . $e->getMessage() . "] db connection problem.");
            flash()->error($errorMessage);
            return redirect()->back();
        }
        if ($e instanceof QueryException) {
            $errorMessage = 'Something went wrong while running database query. Please contact your database server administrator.';
            Log::critical('[Inzaana][' . $e->getMessage() . "] db query problem.");
            flash()->error($errorMessage);
            return redirect()->back();
        }

        return parent::render($request, $e);
    }
}
