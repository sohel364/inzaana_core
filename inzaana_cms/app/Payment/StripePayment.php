<?php
namespace Inzaana\Payment;

interface StripePayment {

    /*
     * Check if the use has access permission
     * @return boolean
     * */
    public function isAccess();

    /*
     * Get the user trial information
     * @param int user_id
     * @return boolean
     * */
    public function getTrialTimeString();

    public function getTrialTimeInt();

    public function getPlanName();

    public function getPlanEndDate();

    public function getPlanRemainDays();

    public function getPlanCost();


} 