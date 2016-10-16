<?php
namespace Inzaana\Payment;

interface StripePayment {

    /*
     * Check if the use has access permission
     * @return boolean
     * */
    public function userAccessPermission();

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

    public function getFeature($plan_name, $feature_name);

    public function featureAccessPermission($uri);

    public function getPlanId();


} 