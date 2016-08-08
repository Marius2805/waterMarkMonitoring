<?php
namespace App\Services\Configuration;

/**
 * Class SettingNotFound
 * @package App\Services\Configuration
 */
class SettingNotFound extends \Exception
{
    /**
     * SettingNotFound constructor.
     * @param string $key
     * @param string $action
     */
    public function __construct(string $key, string $action)
    {
        $message = 'Configuration setting with key "' . $key . '" not found (Tried to ' . $action . ')';
        parent::__construct($message);
    }
}