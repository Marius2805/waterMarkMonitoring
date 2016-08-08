<?php
namespace App\Services\Configuration;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @property string $settings_key
 * @property string $value
 * @package App\Services\Configuration
 */
class Setting extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'settings_key';

    /**
     * @var array
     */
    protected $fillable = ['settings_key', 'value'];

    /**
     * @return string
     */
    public function getKey() : string
    {
        return $this->attributes['settings_key'];
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->attributes['value'];
    }
}