<?php
namespace App\Services\Notification;

use App\Services\Configuration\SettingsRepository;
use App\Services\Measurement\MeasurementRepository;
use App\Services\Measurement\Rating\MeasurementRatingService;
use App\Services\Notification\Sender\Message;
use App\Services\Notification\Sender\SenderContainer;
use Carbon\Carbon;

/**
 * Class NotificationService
 * @package App\Services\Notification
 */
class NotificationService
{
    /**
     * @var SenderContainer
     */
    private $senderContainer;

    /**
     * @var MeasurementRatingService
     */
    private $ratingService;

    /**
     * @var MeasurementRepository
     */
    private $measurementRepository;

    /**
     * @var SettingsRepository
     */
    private $settingsRepository;

    /**
     * NotificationService constructor.
     * @param SenderContainer $senderContainer
     * @param MeasurementRatingService $ratingService
     * @param MeasurementRepository $measurementRepository
     * @param SettingsRepository $settingsRepository
     */
    public function __construct(SenderContainer $senderContainer = null, MeasurementRatingService $ratingService = null, MeasurementRepository $measurementRepository = null, SettingsRepository $settingsRepository = null)
    {
        $this->senderContainer = $senderContainer ?: new SenderContainer();
        $this->ratingService = $ratingService ?: new MeasurementRatingService();
        $this->measurementRepository = $measurementRepository ?: new MeasurementRepository();
        $this->settingsRepository = $settingsRepository ?: new SettingsRepository();
    }

    public function check()
    {
        $restTimeSetting = $this->settingsRepository->get(SettingsRepository::NOTIFICATION_REST_TIME);
        $lastNotificationSetting = $this->settingsRepository->get(SettingsRepository::LAST_NOTIFICATION);

        if (is_null($lastNotificationSetting->value) || Carbon::now()->diffInMinutes(new Carbon($lastNotificationSetting->value)) > $restTimeSetting->value) {
            $lastMeasurement = $this->measurementRepository->getLastMeasurement();

            if ($this->ratingService->warningThresholdReached($lastMeasurement)) {
                $message = new Message($this->getMessage('markWarning', $lastMeasurement->value));
                $this->senderContainer->broadcast($message);
            }

            if ($this->ratingService->measurementGapDetected()) {
                $gap = Carbon::now()->diffInMinutes($lastMeasurement->created_at);
                $message = new Message($this->getMessage('gapWarning', $gap));
                $this->senderContainer->broadcast($message);
            }
        }

        $lastNotificationSetting->value = Carbon::now()->toDateTimeString();
        $this->settingsRepository->save($lastNotificationSetting);
    }

    /**
     * @param string $key
     * @param int $value
     * @return string
     */
    private function getMessage(string $key, $value)
    {
        $message = app('translator')->trans('notification.' . $key);
        return str_replace('<VALUE>', $value, $message);
    }
}