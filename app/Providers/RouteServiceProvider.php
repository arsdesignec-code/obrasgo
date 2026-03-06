<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/pwa.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/included/language.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/emailsettings.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/included/blog.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/included/cookie.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/included/coupons.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/tawk.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/recaptcha.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/google_login.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/facebook_login.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/included/notification.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/top_deals.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/product_review.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/whatsapp.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/mercadopago.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/myfatoorah.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/paypal.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/toyyibpay.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/paytab.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/phonepe.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/mollie.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/khalti.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/xendit.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/quick_call.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/fake_sales_notification.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/product_fake_view.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/wizz_chat.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/age_verification.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/service_card.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/telegram.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/currency.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/question_answer.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/ical_file.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/google_calendar.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/providercalendar.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
