<?php

namespace Innoflash\Zoomconnect\Helpers;

use Innoflash\Zoomconnect\Exceptions\ConfigException;

class Config
{
    private static $methods = [
        'json',
        'xml'
    ];
    /**
     * Finds the email set for ZoomConnect
     */
    public static function getEmail(): string
    {
        return self::findConfig('email');
    }

    /**
     * Retrieves ZoomConnect the API token
     */
    static function getApiToken(): string
    {
        return self::findConfig('api_token');
    }

    /**
     * Retrieves the credentials to use on ZoomConnect
     */
    static function getCredentials(): string
    {
        return self::getEmail() . ':' . self::getApiToken();
    }

    /**
     * Gets the set method to send the SMS
     */
    static function getSMSMethod(): string
    {
        $method = self::findConfig('sms_method');
        return self::validateOption('sms_method', $method, self::$methods);
    }

    /**
     * Searches the config file for the given key
     */
    private static function findConfig(string $configName): string
    {
        $configName = 'zoomconnect.' . $configName;
        if (!config($configName))
            throw ConfigException::missingConfig($configName);
        return config($configName);
    }

    /**
     * Validates the option for the possible values
     */
    private static function validateOption(string $configName, string $value, array $options): string
    {
        $configName = 'zoomconnect.' . $configName;
        if (!in_array($value, $options))
            throw ConfigException::optionOutOfBounds($configName, $value, $options);
        return $value;
    }
}
