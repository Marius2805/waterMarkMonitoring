<?php
namespace App\Services\Measurement;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Measurement
 * @property float $value
 * @package App\Services\Measurement
 */
class Measurement extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['value'];
}