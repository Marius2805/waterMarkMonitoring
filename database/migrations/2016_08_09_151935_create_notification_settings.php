<?php

use App\Services\Configuration\Setting;
use App\Services\Configuration\SettingNotFound;
use App\Services\Configuration\SettingsRepository;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationSettings extends Migration
{
    /**
     * @var SettingsRepository
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new SettingsRepository();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = new Setting(['settings_key' => SettingsRepository::NOTIFICATION_REST_TIME, 'value' => 360]);
        $this->repository->save($setting);

        $setting = new Setting(['settings_key' => SettingsRepository::LAST_NOTIFICATION, 'value' => null]);
        $this->repository->save($setting);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            $this->repository->delete(SettingsRepository::NOTIFICATION_REST_TIME);
        } catch (SettingNotFound $e) {}

        try {
            $this->repository->delete(SettingsRepository::LAST_NOTIFICATION);
        } catch (SettingNotFound $e) {}
    }
}
