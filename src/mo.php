<?php
ini_set('display_errors', 1);
require_once 'config.php';
require_once 'MobinOne.php';


// handle get request
if (isset($_GET['sender']) && isset($_GET['scode'])) {
    $sender = (substr($_GET['sender'], 0, 1) == '0' ? "98" . substr($_GET['sender'], 1) : "98" . $_GET['sender']);
    $shortCode = $_GET['scode'];
    $_SESSION['phonenumber'] = $sender;

    // create MobinOne class
    $mobin = new \ahmadrezaei\mobinone\MobinOne($username, $password, $shortCode, $serviceKey, $sender);

    if(isset($_GET['text']) && $_GET['text'] != '1')
    {
        try {
            $message = 'برای عضویت کلمه 1 را ارسال کنید.';
            $result = $mobin->sendSMS([$sender], [$message], [''], [''], 'mt', [$mobin->randomString()]);
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
        try {
            $message = 'برای عضویت کلمه 1 را ارسال کنید.';
            $result = $mobin->sendSMS([$sender], [$message], [''], [''], 'mt', [$mobin->randomString()]);
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
    }

}