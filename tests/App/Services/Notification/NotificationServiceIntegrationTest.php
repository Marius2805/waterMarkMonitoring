<?php
namespace Tests\App\Services\Notification;

use App\Services\Notification\NotificationService;
use Tests\App\General\IntegrationTest;
use Tests\App\Services\Measurement\MeasurementRepositoryMock;
use Tests\App\Services\Measurement\Rating\MeasurementRatingServiceMock;
use Tests\App\Services\Notification\Sender\SenderContainerMock;

class NotificationServiceIntegrationTest extends IntegrationTest
{
    /**
     * @var NotificationService
     */
    private $service;

    /**
     * @var SenderContainerMock
     */
    private $senderContainerMock;

    public function setUp()
    {
        parent::setUp();

        app('translator')->setLocale('en');

        $this->senderContainerMock    = new SenderContainerMock();
        $measurementRepositoryMock    = new MeasurementRepositoryMock();
        $ratingServiceMock            = new MeasurementRatingServiceMock();

        $this->service = new NotificationService($this->senderContainerMock->getContainer(), $ratingServiceMock->getService(), $measurementRepositoryMock->getRepository());
    }

    public function test_check_restTimeRespected()
    {
        $this->service->check();
        $this->service->check();
        self::assertCount(2, $this->senderContainerMock->getReceivedMessages());
    }
}