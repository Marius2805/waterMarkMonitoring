<?php
use App\Services\Measurement\Measurement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Class MeasurementSeeder
 */
class MeasurementSeeder extends Seeder
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $date = Carbon::today()->subDay(7);
        $lastMeasurement = new Measurement(['value' => rand(11, 30)]);

        while ($date < Carbon::now()) {
            $value = $lastMeasurement->value + rand(-5, 5);
            $measurement = new Measurement(['value' => $value]);
            $measurement->setCreatedAt($date);
            $measurement->save();

            $date->addHours(1);
        }
    }
}