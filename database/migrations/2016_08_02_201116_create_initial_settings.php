<?php

use App\Services\Configuration\Setting;
use App\Services\Configuration\SettingNotFound;
use App\Services\Configuration\SettingsRepository;
use Illuminate\Database\Migrations\Migration;

/**
 * Created settings with initial values
 *
 * Class CreateInitialSettings
 */
class CreateInitialSettings extends Migration
{
    /**
     * @var SettingsRepository
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new SettingsRepository();
    }

    public function up()
    {
        $setting = new Setting(['settings_key' => SettingsRepository::WATER_MARK_WARNING_THRESHOLD, 'value' => 10]);
        $this->repository->save($setting);

        $setting = new Setting(['settings_key' => SettingsRepository::MEASUREMENT_GAP_WARNING_THRESHOLD, 'value' => 180]);
        $this->repository->save($setting);
    }

    public function down()
    {
        try {
            $this->repository->delete(SettingsRepository::WATER_MARK_WARNING_THRESHOLD);
        } catch (SettingNotFound $e) {}

        try {
            $this->repository->delete(SettingsRepository::MEASUREMENT_GAP_WARNING_THRESHOLD);
        } catch (SettingNotFound $e) {}
    }
}
