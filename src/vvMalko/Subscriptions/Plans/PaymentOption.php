<?php namespace vvMalko\Subscriptions\Plans;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class PaymentOption
 *
 * Payment option for a plan
 *
 * @package vvMalko\Subscriptions\Plans
 */
class PaymentOption implements Arrayable
{
	/**
	 * payment
	 *
	 * @var string
	 */
	private $payment;

	/**
	 * price
	 *
	 * @var float
	 */
	private $price;

	/**
	 * quantity
	 *
	 * @var int
	 */
	private $quantity;

	/**
	 * days
	 *
	 * @var int
	 */
	private $days;

    /**
     * trial days
     *
     * @var int
     */
    private $trial;

	/**
	 * payment methods
	 *
	 * @var array
	 */
	private $methods;

	/**
	 * @param string $payment
	 * @param float $price
	 * @param int $quantity
	 * @param int $days
	 * @param array $methods
	 */
	public function __construct($payment, $price, $quantity = 1, $days = 30, array $methods = [])
	{
		$this->payment = strtoupper($payment);
		$this->price = $price;
		$this->quantity = $quantity;
		$this->days = $days;
		$this->methods = array_map('strtolower', $methods);
	}

	/**
	 * returns Payment
	 *
	 * @return string
	 */
	public function payment()
	{
		return $this->payment;
	}

	/**
	 * returns Price
	 *
	 * @param bool $formatted
	 * @param int $decimals
	 * @param string $dec_point
	 * @param string $thousands_sep
	 * @param string $currency
	 *
	 * @return float
	 */
	public function price($formatted = false, $decimals = 2 , $dec_point = ',' , $thousands_sep = '.', $currency = '&euro;')
	{
		return $formatted
			? trim(number_format($this->price, $decimals, $dec_point, $thousands_sep) . ' ' . $currency)
			: $this->price;
	}

	/**
	 * returns the total price
	 *
	 * @return float
	 */
	public function total()
	{
		return $this->price(false) * $this->quantity();
	}

	/**
	 * returns Quantity
	 *
	 * @return int
	 */
	public function quantity()
	{
		return $this->quantity;
	}

	/**
	 * returns number of days
	 *
	 * @return int
	 */
	public function days()
	{
		return $this->quantity() * $this->period();
	}

	/**
	 * returns days per period
	 *
	 * @return int
	 */
	public function period()
	{
		return $this->days;
	}

	/**
	 * returns all methods
	 *
	 * @return array
	 */
	public function methods()
	{
		return $this->methods;
	}

	/**
	 * do we support a method
	 *
	 * @param string $method
	 *
	 * @return bool
	 */
	public function supportsMethod($method)
	{
		return in_array(strtolower($method), $this->methods());
	}

	/**
	 * Get the instance as an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return [
			'payment' => $this->payment(),
			'price' => $this->price(),
			'quantity' => $this->quantity(),
			'days' => $this->days,
			'methods' => $this->methods(),
		];
	}
}