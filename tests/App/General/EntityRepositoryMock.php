<?php
namespace Tests\App\General;

use App\General\EntityRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityRepositoryMock
 * @package tests\App\General
 */
abstract class EntityRepositoryMock extends \PHPUnit_Framework_TestCase
{
    public function getRepository() : EntityRepository
    {
        $repository = $this->getMockBuilder($this->getRepositoryClassName())->getMock();

        $repository->method('getById')
            ->will($this->returnCallback([$this, 'getByIdCallback']));

        $repository->method('save')
            ->will($this->returnCallback([$this, 'saveEntity']));


        return $repository;
    }

    public function getByIdCallback(int $id)
    {
        $this->createEntity($id);
    }

    public function saveEntity(Model $entity)
    {
        if (is_null($entity->id)) {
            $entity->id = rand(1, 1000);
        }
    }

    public function createEntity(int $id = null) : Model
    {
        throw new \RuntimeException('Method createEntity needs to be defined in ' . static::class);
    }

    abstract protected function getRepositoryClassName() : string;
}