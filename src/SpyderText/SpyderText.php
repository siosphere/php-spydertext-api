<?php
namespace SpyderText;

use SpyderText\Authentication\AuthenticationSDK;
use SpyderText\Account\AccountSDK;
use SpyderText\Program\ProgramSDK;
use SpyderText\Base\Component\Request;
use SpyderText\Base\ILogger;

class SpyderText
{
    const TOKEN_HEADER = 'SPYDR-Token';
    const DEVICE_TOKEN_HEADER = 'SPYDR-DeviceToken';

    protected static $authenticationSDK;

    protected static $accountSDK;

    protected static $programSDK;

    protected static $apiKey;

    protected static $deviceToken;

    protected static $logger;

    protected static $debug = false;

    public static function setApiKey(string $apiKey)
    {
        static::$apiKey = $apiKey;
    }

    public static function setDeviceToken(string $deviceToken)
    {
        static::$deviceToken = $deviceToken;
    }

    public static function signRequest(Request $request)
    {
        $request
            ->addHeader(sprintf('%s:%s', self::TOKEN_HEADER, static::$apiKey));

        if(static::$deviceToken) {
            $request 
                ->addHeader(sprintf('%s:%s', self::DEVICE_TOKEN_HEADER, static::$deviceToken));
        }
    }

    public static function setLogger(ILogger $logger)
    {
        static::$logger = $logger;
    }

    public static function getLogger() : ILogger
    {
        return static::$logger;
    }

    public static function setDebug(bool $debug)
    {
        static::$debug = $debug;
    }

    public static function getDebug() : bool
    {
        return static::$debug;
    }

    public static function Authentication() : AuthenticationSDK
    {
        if(static::$authenticationSDK) {
            return static::$authenticationSDK;
        }

        return static::$authenticationSDK = new AuthenticationSDK();
    }

    public static function Account() : AccountSDK
    {
        if(static::$accountSDK) {
            return static::$accountSDK;
        }

        return static::$accountSDK = new AccountSDK();
    }

    public static function Program() : ProgramSDK
    {
        if(static::$programSDK) {
            return static::$programSDK;
        }

        return static::$programSDK = new ProgramSDK();
    }

    public static function Log(string $message)
    {
        if(static::$logger) {
            return static::$logger->log($message);
        }

        static::$logger = new FileLogger();

        return static::$logger->log($message);
    }
}