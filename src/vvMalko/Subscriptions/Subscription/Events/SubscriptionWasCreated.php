<?php namespace vvMalko\Subscriptions\Subscription\Events;

use vvMalko\Subscriptions\Plans\PaymentOption;
use vvMalko\Subscriptions\Plans\Plan;
use vvMalko\Subscriptions\Subscription\Subscription;

/**
 * Class SubscriptionWasCreated
 *
 * Event was fired when subscription created
 *
 * @package vvMalko\Subscriptions\Subscription\Events
 */
class SubscriptionWasCreated
{
	/**
	 * created subscription
	 *
	 * @var \vvMalko\Subscriptions\Subscription\Subscription
	 */
	public $subscription;

	/**
	 * plan
	 *
	 * @var \vvMalko\Subscriptions\Plans\Plan
	 */
	public $plan;

	/**
	 * payment option
	 *
	 * @var \vvMalko\Subscriptions\Plans\PaymentOption
	 */
	public $paymentOption;

	/**
	 * @param \vvMalko\Subscriptions\Subscription\Subscription $subscription
	 * @param \vvMalko\Subscriptions\Plans\Plan $plan
	 * @param \vvMalko\Subscriptions\Plans\PaymentOption $paymentOption
	 */
	public function __construct(Subscription $subscription, Plan $plan, PaymentOption $paymentOption)
	{
		$this->subscription = $subscription;
		$this->plan = $plan;
		$this->paymentOption = $paymentOption;
	}
}