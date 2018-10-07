<?php

namespace Corp\Exceptions;

use Corp\Http\Controllers\SiteController;
use Corp\Menu;
use Corp\Repositories\MenuRepository;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Log;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        if ($this->isHttpException($exception)) {
            $code = $exception->getStatusCode();
            switch ($code) {
                case '404':
                    $obj = new SiteController(new MenuRepository(new Menu()));
                    $navigation_view = view(config('settings.theme') . '.navigation')
                        ->with('menu', $obj->getMenu())
                        ->render();
                    Log::alert('Страница не найдена - ' . $request->url());
                    return response()->view('errors.404', ['bar' => 'no', 'title' => 'Страница не найдена', 'navigation_view' => $navigation_view]);
            }
        }

        return parent::render($request, $exception);
    }
}
