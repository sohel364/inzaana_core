<?php

namespace Inzaana\Exceptions;

use Exception;
use Stripe\Error\Card;
use Stripe\Error\RateLimit;
use Stripe\Error\InvalidRequest;
use Stripe\Error\Authentication;
use Stripe\Error\ApiConnection;
use Stripe\Error\Base;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Encryption\DecryptException;

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
        if ($e instanceof HttpException) {
            $status = $e->getStatusCode();
            $errors[403] = 'You are not authorized to route this action as you are tried. Please follow the routes as we guide you.';

            if (view()->exists("errors.{$status}"))
            {
                return response()->view("errors.{$status}", [ 'errors' => collect($errors) ], $status);
            }
            else
            {
                return (new SymfonyDisplayer(config('app.debug')))->createResponse($e);
            }
        }

        /*
         * Stripe Exception Handling
         * Exception List: Card exception, RateLimit exception, InvalidRequest exception, Authentication Exception
         * Exception List: ApiConnection exception, Base exception
         * All of this exception handle in this section
         * */
        if($e instanceof Card){

        }
        if($e instanceof RateLimit){

        }
        if($e instanceof InvalidRequest){
            $errorMessage = 'Your requested plan is not exists in Stripe Database.';
            Log::critical('[Stripe][' . $e->getMessage() . "] Stripe plan not found problem.");
            flash()->error($errorMessage);
            return redirect()->back();
        }
        if($e instanceof Authentication){
            $errorMessage = 'Stripe Authentication Problem. Please make sure your provided api key is correct.';
            Log::critical('[Stripe][' . $e->getMessage() . "] Stripe authentication problem.");
            flash()->error($errorMessage);
            return redirect()->back();
        }
        if($e instanceof ApiConnection){
            $errorMessage = 'Could not connect to Stripe. Please make sure your internet connection is fine.';
            Log::critical('[Stripe][' . $e->getMessage() . "] Stripe Api Connection problem.");
            flash()->error($errorMessage);
            return redirect()->back();
        }
        if($e instanceof Base){
            $errorMessage = 'Stripe Problem';
            Log::critical('[Stripe][' . $e->getMessage() . "] Stripe problem.");
            flash()->error($e->getMessage());
            return redirect()->back();
        }
        /*
         * End of Stripe Exception Handling
         *
         * */
        if($e instanceof DecryptException)
        {
            $errorMessage = 'DecryptException. Do not change your encryption string.';
            Log::critical('[Inzaana][' . $e->getMessage() . "] Encryption Decryption problem.");
            flash()->error($errorMessage);
            return redirect()->back();
        }

        return parent::render($request, $e);
    }
}
