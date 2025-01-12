<?php

class PremiumController {
    private $premium;

    public function __construct() {
        $this->premium = new Premium();
    }

    public function upgrade($username, $paymentMethod, $accountNumber) {
        $this->premium->upgradeToPremium($username, $paymentMethod, $accountNumber);
        header("Location: /premium_success.php");
    }
}
