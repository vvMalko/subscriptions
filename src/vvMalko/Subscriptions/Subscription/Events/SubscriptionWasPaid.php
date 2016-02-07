<?php namespace vvMalko\Subscriptions\Subscription\Events;

use vvMalko\Subscriptions\Subscription\Period;

/**
 * Class SubscriptionWasPaid
 *
 * Event will be fired when a subscription was paid (a period was paid)
 *
 * @package vvMalko\Subscriptions\Subscription\Events
 */
class SubscriptionWasPaid
{
	/**
	 * paid period
	 *
	 * @var \vvMalko\Subscriptions\Subscription\Period
	 */
	public $period;

	/**
	 * paid subscription
	 *
	 * @var \vvMalko\Subscriptions\Subscription\Subscription
	 */
	public $subscription;

	/**
	 * @param \vvMalko\Subscriptions\Subscription\Period $period
	 */
	public function __construct(Period $period)
	{
		$this->period = $period;
		$this->subscription = $period->subscription;
	}
}