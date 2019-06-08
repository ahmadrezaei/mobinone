<?php
ini_set('display_errors', 1);
require_once 'config.php';
require_once 'MobinOne.php';

$message = 'مشترک گرامی، سرویس سبز میزبان شماست.
اینجا می توانید ترفندهای متنوع و ویدیو های آموزشی در زمینه های کاربردی مورد نظرتان را بدون محدودیت تماشا کنید. محتوای سرویس برای شما با تعرفه روزانه پانصد تومان قابل دسترسی است. لغو با ارسال خاموش یا off.
http://sabz98.com';

// handle get request
if (isset($_GET['msisdn']) && isset($_GET['shortcode']) && isset($_GET['chargecode']))
{
    $sender = (substr($_GET['msisdn'], 0, 1) == '0' ? "98" . substr($_GET['msisdn'], 1) : "98" . $_GET['msisdn']);
    $shortCode = $_GET['shortcode'];

    // create MobinOne class
    $mobin = new \ahmadrezaei\mobinone\MobinOne($username, $password, $shortCode, $serviceKey, $sender);

    try {
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