<?php
namespace App\Services\Configuration;

/**
 * Class SettingsRepository
 * @package App\Services\Configuration
 */
class SettingsRepository
{
    const WATER_MARK_WARNING_THRESHOLD      = 'waterMarkWarningThreshold';
    const MEASUREMENT_GAP_WARNING_THRESHOLD = 'gapWarningThreshold';

    /**
     * @param string $key
     * @return Setting
     * @throws SettingNotFound
     */
    public function get(string $key) : Setting
    {
        $setting = $this->loadSetting($key);

        if ($setting == null) {
            throw new SettingNotFound($key, 'READ');
        }

        return $setting;
    }

    /**
     * @param Setting $setting
     */
    public function save(Setting $setting)
    {
        $cacheKey = $this->cacheKey($setting->getKey());
        $setting->save();

        \Cache::forget($cacheKey);
        \Cache::put($cacheKey, $setting);
    }

    /**
     * @param string $settingsKey
     * @throws SettingNotFound
     */
    public function delete(string $settingsKey)
    {
        try {
            $setting = $this->get($settingsKey);
        } catch (SettingNotFound $e) {
            throw new SettingNotFound($settingsKey, 'DELETE');
        }
        $setting->delete();

        \Cache::forget($this->cacheKey($settingsKey));
    }

    /**
     * @param string $key
     * @return Setting
     */
    protected function loadSetting(string $key)
    {
        $setting = \Cache::get($key);

        if ($setting == null) {
            $setting = Setting::where('settings_key', '=', $key)->first();

            if ($setting != null) {
                \Cache::put($this->cacheKey($key), $setting);
            }
        }

        return $setting;
    }

    /**
     * @param string $settingsKey
     * @return string
     */
    protected function cacheKey(string $settingsKey) : string
    {
        return 'Setting-' . $settingsKey;
    }
}