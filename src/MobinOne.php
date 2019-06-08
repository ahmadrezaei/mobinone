<?php
namespace ahmadrezaei\mobinone;

use SoapClient;

/**
 * Class MobinOne
 * @package ahmadrezaei\mobinone
 */
class MobinOne
{
    /**
     * @var string $username
     */
    protected $username;

    /**
     * @var string $password
     */
    protected $password;

    /**
     * @var string $shortCode
     */
    protected $shortCode;

    /**
     * @var string $serviceKey
     */
    protected $serviceKey;

    /**
     * @var string $phoneNumber
     */
    protected $phoneNumber;

    /**
     * Client url to request
     *
     * @var string $url
     */
    protected $url = 'http://10.20.9.6:8080/server.php?wsdl';

    /**
     * MobinOne constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $shortCode
     * @param string $serviceKey
     * @param string $phoneNumber
     * @param string $url
     */
    public function __construct($username, $password, $shortCode, $serviceKey, $phoneNumber, $url = '')
    {
        $this->username    = $username;
        $this->password    = $password;
        $this->shortCode   = $shortCode;
        $this->serviceKey  = $serviceKey;
        $this->phoneNumber = $phoneNumber;

        if(!empty($url)) $this->url = $url;
    }

    /**
     * Send SMS to one user or group of users
     *
     * @param array $phoneNumbers
     * @param array $messages
     * @param string $chargeCode
     * @param string $amount
     * @param string $type
     * @param string $requestId
     * @return mixed
     */
    public function sendSMS($phoneNumbers, $messages, $chargeCode, $amount, $type, $requestId)
    {
        $client = new SoapClient($this->url);
        $response = $client->sendSms([
            "username" => $this->username,
            "password" => $this->password,
            "shortcode" => $this->shortCode,
            "servicekey" => $this->serviceKey,
            "number" => $phoneNumbers,
            "message" => $messages,
            "chargecode" => $chargeCode,
            "amount" => $amount,
            "type" => $type,
            "requestId" => $requestId
        ]);

        if(is_string($response[0])) {
            $result = explode('-', $response[0]);
        } else {
            $result = $response;
        }

        return $result;
    }

    /**
     * Subscribe/Unsubscribe user to VAS service
     *
     * @param string $chargeCode
     * @param string $amount
     * @param string $requestId
     * @return array
     */
    public function inAppCharge($chargeCode, $requestId, $amount = '')
    {
        $client = new SoapClient($this->url);
        $response = $client->inAppCharge($this->username, $this->password, $this->shortCode, $this->serviceKey, $chargeCode, $this->phoneNumber, $amount, $requestId);
        $result = explode('-', $response);
        return $result;
    }

    /**
     * Confirm user subscribe
     *
     * @param string $OTPTransactionId
     * @param string $TXCode
     * @param string $transactionPin
     * @return array
     */
    public function inAppChargeConfirm($OTPTransactionId, $TXCode, $transactionPin)
    {
        $client = new SoapClient($this->url);
        $response = $client->inAppChargeConfirm($this->username, $this->password, $OTPTransactionId, $TXCode, $transactionPin);
        $result = explode('-', $response);
        return $result;
    }

    /**
     * Generate random string
     *
     * @param int $length
     * @return string
     */
    function randomString($length = 32) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }
}