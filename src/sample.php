<?php
session_start();
require_once 'config.php';
require_once 'MobinOne.php';

if(isset($_GET['phone']) && !empty($_GET['phone']))
{
    // create MobinOne class
    $mobin = new \ahmadrezaei\mobinone\MobinOne($username, $password, $shortCode, $serviceKey, $_GET['phone']);

    /* register user to VAS service */
    $result = $mobin->inAppCharge($chargeCode, $mobin->randomString());
    if($result[0] == 'Success') {
        $_SESSION['OTPTransactionId'] = $result[2];
        $_SESSION['TxCode'] = $result[3];
        $_SESSION['phone'] = $_GET['phone'];
        echo 'message sent successfully';
    } else {
        echo '<pre>';
        print_r($result);
    }
}
else if(isset($_GET['code']) && !empty($_GET['code']))
{
    // create MobinOne class
    $mobin = new \ahmadrezaei\mobinone\MobinOne($username, $password, $shortCode, $serviceKey, $_SESSION['phone']);

    /* confirm user subscribe */
    $result = $mobin->inAppChargeConfirm($_SESSION['OTPTransactionId'], $_SESSION['TxCode'], $_GET['code']);
    if ($result[0] == 'Success') {
        echo 'user subscribed successfully' . '<br>';

        try {
            $result = $mobin->sendSMS([$_SESSION['phone']], [$message], [''], [''], 'mt', [$mobin->randomString()]);
            if($result[0] == 'Success') {
                echo 'SMS sent successfully.';
            } else {
                echo '<pre>';
                print_r($result);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    } else {
        echo '<pre>';
        print_r($result);
    }
}
