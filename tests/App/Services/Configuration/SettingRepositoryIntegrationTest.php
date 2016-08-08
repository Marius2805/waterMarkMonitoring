<?php
namespace Tests\App\Services\Configuration;

use App\Services\Configuration\Setting;
use App\Services\Configuration\SettingsRepository;
use Tests\App\General\IntegrationTest;

/**
 * Class SettingRepositoryIntegrationTest
 * @package Tests\App\Services\Configuration
 */
class SettingRepositoryIntegrationTest extends IntegrationTest
{
    /**
     * @var SettingsRepository
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new SettingsRepository();
    }

    /**
     * @expectedException \App\Services\Configuration\SettingNotFound
     * @expectedExceptionMessage Configuration setting with key "NOT_EXISTING" not found (Tried to READ)
     */
    public function test_get_settingsNotFound()
    {
        $this->repository->get('NOT_EXISTING');
    }

    public function test_save_settingPersistedSuccessfully()
    {
        $setting = new Setting(['settings_key' => 'testKey', 'value' => 'dummyValue']);
        $this->repository->save($setting);
        \Cache::flush();

        $result = $this->repository->get('testKey');
        self::assertInstanceOf(Setting::class, $result);
        self::assertEquals('testKey', $result->getKey());
        self::assertEquals('dummyValue', $result->getValue());
    }

    /**
     * @depends test_save_settingPersistedSuccessfully
     */
    public function test_get_cacheUsed()
    {
        $setting = new Setting(['settings_key' => 'testKeyCache', 'value' => 'cacheUsed']);
        $this->repository->save($setting);
        $setting->delete();

        $result = $this->repository->get('testKeyCache');
        self::assertEquals('testKeyCache', $result->getKey());
        self::assertEquals('cacheUsed', $result->getValue());
    }

    /**
     * @expectedException \App\Services\Configuration\SettingNotFound
     * @expectedExceptionMessage Configuration setting with key "NOT_EXISTENT" not found (Tried to DELETE)
     */
    public function test_delete_keyNotExists()
    {
        $this->repository->delete('NOT_EXISTENT');
    }

    /**
     * @depends test_get_settingsNotFound
     * @expectedException \App\Services\Configuration\SettingNotFound
     * @expectedExceptionMessage Configuration setting with key "testKeyDeleted" not found (Tried to READ)
     */
    public function test_delete_deletedFromDatabaseAndCache()
    {
        $setting = new Setting(['settings_key' => 'testKeyDeleted', 'value' => 'cacheUsed']);
        $this->repository->save($setting);
        $this->repository->delete('testKeyDeleted');

        $this->repository->get('testKeyDeleted');
    }
}