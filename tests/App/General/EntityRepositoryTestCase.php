<?php
namespace Tests\App\General;

use App\General\EntityRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityRepositoryTestCase
 * @package Tests\App\General
 */
abstract class EntityRepositoryTestCase extends IntegrationTest
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entityClass;

    public function setUp()
    {
        parent::setUp();

        $this->repository = $this->getRepository();
        $this->entityClass = $this->getExpectedEntityClass();
        $this->deleteAll($this->repository);
    }

    abstract protected function getRepository() : EntityRepository;

    abstract protected function getExpectedEntityClass() : string;

    abstract protected function createEntity(bool $persist = true) : Model;

    public function test_getById_correctEntityReturned()
    {
        $expected = $this->createEntity();
        $entity = $this->repository->getById($expected->getKey());

        self::assertNotNull($entity);
        self::assertInstanceOf($this->entityClass, $entity);
        self::assertEquals($expected->getKey(), $entity->getKey());
    }

    public function test_getById_cacheUsed()
    {
        $expected = $this->createEntity();
        $entity1 = $this->repository->getById($expected->getKey());
        $entity2 = $this->repository->getById($expected->getKey());

        if (!$this->repository->cacheEnabled()) {
            self::assertNotSame($entity1, $entity2);
        } else {
            self::assertSame($entity1, $entity2);
        }
    }

    /**
     * @depends test_getById_correctEntityReturned
     */
    public function test_save_success()
    {
        $expected = $this->createEntity(false);
        $this->repository->save($expected);
        $returned = $this->repository->getById($expected->getKey());

        self::assertNotNull($expected->getKey());
        self::assertEquals($expected->attributesToArray(), $returned->attributesToArray());
    }

    /**
     * @expectedException \App\General\EntityNotFoundException
     * @expectedExceptionMessage Unable to find
     */
    public function test_delete_success()
    {
        $entity = $this->createEntity();
        $this->repository->delete($entity);
        $this->repository->getById($entity->getKey());
    }
}