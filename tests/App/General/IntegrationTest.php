<?php
namespace Tests\App\General;
use App\CustomerManagement\Animals\AnimalRepository;
use App\CustomerManagement\Appointment\AppointmentRepository;
use App\CustomerManagement\Customer\CustomerRepository;
use App\Invoice\InvoiceRepository;
use App\Models\Animal\Animal;
use App\Models\Appointment\Appointment;
use App\Models\Customer\Customer;
use App\Models\Invoice\Invoice;
use DB;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\App\CustomerManagement\Animals\AnimalRepositoryMock;
use Tests\App\CustomerManagement\Appointment\AppointmentRepositoryMock;
use Tests\App\CustomerManagement\Customer\CustomerRepositoryMock;
use Tests\App\Invoice\InvoiceRepositoryMock;
use Tests\TestCase;

/**
 * Class IntegrationTest
 * @package Tests\App\General
 */
abstract class IntegrationTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}