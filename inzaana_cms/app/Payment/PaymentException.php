<?php
/**
 * Created by PhpStorm.
 * User: sk
 * Date: 8/25/2016
 * Time: 6:29 PM
 */

namespace Inzaana\Payment;

use Exception;
class PaymentException extends Exception {

    public function __construct($payment)
    {
        $this->message = "Payment Exception ".$payment;
    }
} 