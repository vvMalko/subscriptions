<?php namespace vvMalko\Subscriptions\Subscription\Contracts;

/**
 * Interface SubscriptionSubscriber
 *
 * @package vvMalko\Subscriptions\Subscription\Contracts
 */
interface SubscriptionSubscriber
{
	/**
	 * returns the subscriber id
	 *
	 * @return int
	 */
	public function getSubscriberId();

	/**
	 * returns the subscriber model name
	 *
	 * @return string
	 */
	public function getSubscriberModel();
}