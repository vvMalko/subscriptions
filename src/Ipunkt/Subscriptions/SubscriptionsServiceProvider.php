<?php namespace Ipunkt\Subscriptions;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Ipunkt\Subscriptions\Plans\PlanRepository;

class SubscriptionsServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * booting the service
	 */
	public function boot()
	{
		$this->publishes([
		    dirname(dirname(dirname(__FILE__))) . '/config/plans.php' =>  config_path('plans.php'),
		]);


		$this->publishes([
		   dirname(dirname(dirname(__FILE__))) . '/migrations/' => base_path('/database/migrations')
		], 'migrations');


	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        /** @var \Illuminate\Config\Repository $config */
        $plans = config('ipunkt.plans');
        $default_plan = config('ipunkt.defaults');

        $this->app->bind('Ipunkt\Subscriptions\Plans\PlanRepository', function () use($plans,$default_plan)
        {
            $repository = new PlanRepository($plans);
            $repository->setDefaultPlan($default_plan);

            return $repository;
        });

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}
}