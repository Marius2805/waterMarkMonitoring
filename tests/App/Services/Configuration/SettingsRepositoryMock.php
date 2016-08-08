<?php
namespace Tests\App\Services\Configuration;

use App\Services\Configuration\Setting;
use App\Services\Configuration\SettingNotFound;
use App\Services\Configuration\SettingsRepository;

/**
 * Class SettingsRepositoryMock
 * @package Tests\App\Services\Configuration
 */
class SettingsRepositoryMock extends \PHPUnit_Framework_TestCase
{
    /**
     * @return SettingsRepository
     */
    public function getRepository() : SettingsRepository
    {
        $repository = $this->getMockBuilder(SettingsRepository::class)->getMock();
        $repository->method('get')->will(self::returnCallback([$this, 'getCallback']));

        return $repository;
    }

    /**
     * @param string $key
     * @return Setting
     * @throws SettingNotFound
     */
    public function getCallback(string $key) : Setting
    {
        switch ($key) {
            case SettingsRepository::WATER_MARK_WARNING_THRESHOLD:
                return new Setting(['settings_key' => $key, 'value' => 10]);
            case SettingsRepository::MEASUREMENT_GAP_WARNING_THRESHOLD:
                return new Setting(['settings_key' => $key, 'value' => 180]);
            default:
                throw new SettingNotFound($key, 'READ');
        }
    }
}