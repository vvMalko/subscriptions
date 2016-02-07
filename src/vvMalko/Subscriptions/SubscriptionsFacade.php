<?php namespace vvMalko\Subscriptions;

use Illuminate\Support\Facades\Facade;

/**
 * Class SubscriptionsFacade
 *
 *
 *
 * @package vvMalko\Subscriptions
 */
class SubscriptionsFacade extends Facade
{
	/**
	 * facade accessor
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'vvMalko\Subscriptions\SubscriptionManager';
	}
}