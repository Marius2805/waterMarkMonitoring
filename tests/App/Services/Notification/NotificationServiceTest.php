<?php
namespace Tests\App\Services\Notification;

use App\Services\Notification\NotificationService;
use App\Services\Notification\Sender\Message;
use Carbon\Carbon;
use Tests\App\Services\Configuration\SettingsRepositoryMock;
use Tests\App\Services\Measurement\MeasurementRepositoryMock;
use Tests\App\Services\Measurement\Rating\MeasurementRatingServiceMock;
use Tests\App\Services\Notification\Sender\SenderContainerMock;
use Tests\TestCase;

/**
 * Class NotificationServiceTest
 * @package Tests\App\Services\Notification
 */
class NotificationServiceTest extends TestCase
{
    /**
     * @var NotificationService
     */
    private $service;

    /**
     * @var SenderContainerMock
     */
    private $senderContainerMock;

    /**
     * @var MeasurementRatingServiceMock
     */
    private $ratingServiceMock;

    /**
     * @var SettingsRepositoryMock
     */
    private $settingsRepositoryMock;

    public function setUp()
    {
        parent::setUp();

        app('translator')->setLocale('en');

        $this->senderContainerMock    = new SenderContainerMock();
        $this->settingsRepositoryMock = new SettingsRepositoryMock();
        $measurementRepositoryMock    = new MeasurementRepositoryMock();
        $this->ratingServiceMock      = new MeasurementRatingServiceMock();

        $this->service = new NotificationService($this->senderContainerMock->getContainer(), $this->ratingServiceMock->getService(), $measurementRepositoryMock->getRepository(), $this->settingsRepositoryMock->getRepository());
    }

    public function test_check_bothWarnings_twoMessages()
    {
        $this->service->check();
        self::assertCount(2, $this->senderContainerMock->getReceivedMessages());
    }

    public function test_check_thresholdWarning_oneMessages()
    {
        $this->ratingServiceMock->setMeasurementGapDetectedResult(false);
        $this->service->check();
        self::assertCount(1, $this->senderContainerMock->getReceivedMessages());
    }

    public function test_check_gapWarning_oneMessages()
    {
        $this->ratingServiceMock->setWarningThresholdReachedResult(false);
        $this->service->check();
        self::assertCount(1, $this->senderContainerMock->getReceivedMessages());
    }

    public function test_check_noWarnings_noMessages()
    {
        $this->ratingServiceMock->setWarningThresholdReachedResult(false);
        $this->ratingServiceMock->setMeasurementGapDetectedResult(false);
        $this->service->check();
        self::assertCount(0, $this->senderContainerMock->getReceivedMessages());
    }

    public function test_check_markWarning_messageCorrect()
    {
        $this->ratingServiceMock->setMeasurementGapDetectedResult(false);
        $this->service->check();
        /** @var Message[] $messages */
        $messages = array_values($this->senderContainerMock->getReceivedMessages());
        self::assertEquals('[Watermark monitoring] Warning! The current watermark is 15 cm', $messages[0]->getMessage());
    }

    public function test_check_gapkWarning_messageCorrect()
    {
        $this->ratingServiceMock->setWarningThresholdReachedResult(false);
        $this->service->check();
        /** @var Message[] $messages */
        $messages = array_values($this->senderContainerMock->getReceivedMessages());
        self::assertEquals('[Watermark monitoring] No current measurement values available. The last measurement was received 30 minutes ago.', $messages[0]->getMessage());
    }

    public function test_check_restTimeRespected()
    {
        $this->settingsRepositoryMock->setLastNotificationValue(Carbon::now());
        $this->service->check();
        self::assertCount(0, $this->senderContainerMock->getReceivedMessages());
    }

    public function test_check_lastNotificationOlderThenRestTime()
    {
        $this->settingsRepositoryMock->setLastNotificationValue(Carbon::now()->subDays(3));
        $this->service->check();
        self::assertCount(2, $this->senderContainerMock->getReceivedMessages());
    }
}