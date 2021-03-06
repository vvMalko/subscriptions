<?php namespace vvMalko\Subscriptions\Subscription;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use vvMalko\Subscriptions\Subscription\Contracts\SubscriptionSubscriber;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class Subscription
 *
 * Subscription entity
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $model_class
 * @property string $plan
 * @property \Carbon\Carbon $trial_ends_at
 * @property \Carbon\Carbon $subscription_ends_at
 * @property string $state
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|Subscription whereId($value)
 * @method static \Illuminate\Database\Query\Builder|Subscription whereModelId($value)
 * @method static \Illuminate\Database\Query\Builder|Subscription whereModelClass($value)
 * @method static \Illuminate\Database\Query\Builder|Subscription wherePlan($value)
 * @method static \Illuminate\Database\Query\Builder|Subscription whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Query\Builder|Subscription whereSubscriptionEndsAt($value)
 * @method static \Illuminate\Database\Query\Builder|Subscription whereState($value)
 * @property-read \Illuminate\Database\Eloquent\Model $subscriber
 * @property-read \vvMalko\Subscriptions\Subscription\Period[] $periods
 *
 * @package vvMalko\Subscriptions\Subscription
 */
class Subscription extends Model
{
	use EventGenerator;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'model_id',
		'model_class',
		'plan',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	/**
	 * returns subscriber
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function subscriber() {
		return $this->morphTo('Company', 'model_class', 'model_id');
	}

	/**
	 * related periods
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function periods()
	{
		return $this->hasMany('\vvMalko\Subscriptions\Subscription\Period');
	}

	/**
	 * returns current period
	 *
	 * @return Period|static|null
	 */
	public function currentPeriod()
	{
		$now = Carbon::now();

		return $this->periods()
			->where('start', '<=', $now)
			->where('end', '>=', $now)
			->first();
	}

	/**
	 * returns last period
	 *
	 * @return Period|static|null
	 */
	public function lastPeriod()
	{
		return $this->periods()->orderBy('id', 'DESC')->first();
	}

	/**
	 * is the subscription subscribed to the given subscriber
	 *
	 * @param SubscriptionSubscriber $subscriber
	 *
	 * @return bool
	 */
	public function isSubscribedTo(SubscriptionSubscriber $subscriber)
	{
		return $this->model_id == $subscriber->getSubscriberId()
			&& $this->model_class == $subscriber->getSubscriberModel();
	}

	/**
	 * are we on trial period
	 *
	 * @return bool
	 */
	public function onTrial()
	{
		return $this->trial_ends_at->isFuture();
	}

	/**
	 * is the subscription paid
	 *
	 * @return bool
	 */
	public function paid()
	{
		$currentPeriod = $this->currentPeriod();
		if (null === $currentPeriod) {
			$currentPeriod = $this->lastPeriod();
			if (null !== $currentPeriod && ! $currentPeriod->start->isFuture())
				$currentPeriod = null;
		}

		return null !== $currentPeriod && $currentPeriod->isPaid();
	}
}