<?php
namespace App\General;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package App\Repository
 */
abstract class EntityRepository
{
    /**
     * @var array
     */
    static protected $cache = [];

    /**
     * @var string
     */
    protected $entityClass;

    public function __construct()
    {
        $this->entityClass = $this->getEntityClass();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return call_user_func($this->entityClass . '::all');
    }

    /**
     * Gets a entity by its ID
     * @param int $id
     * @return Model
     */
    public function getById(int $id) : Model
    {
        if (!isset(self::$cache[$this->getEntityClass()][$id])) {
            $entity = call_user_func($this->entityClass . '::find', $id);

            if ($entity == null) {
                throw new EntityNotFoundException($this->entityClass, $id);
            }

            $this->addToCache($entity);
        }

        return self::$cache[$this->getEntityClass()][$id];
    }

    /**
     * @param Model $entity
     */
    public function save(Model $entity)
    {
        $entity->save();
        $this->addToCache($entity);
    }

    /**
     * @param Model $entity
     */
    public function delete(Model $entity)
    {
        $this->removeFromCache($entity);
        $entity->delete();
    }

    /**
     * Returns the class of the entity belonging to the repository
     * @return string
     */
    abstract protected function getEntityClass() : string;

    /**
     * @param Model $entity
     */
    protected function addToCache(Model $entity)
    {
        self::$cache[$this->getEntityClass()][$entity->getKey()] = $entity;
    }

    /**
     * @param Model $entity
     */
    protected function removeFromCache(Model $entity)
    {
        unset(self::$cache[$this->getEntityClass()][$entity->getKey()]);
    }

    /**
     * @return string
     */
    protected function getTable() : string
    {
        /** @var Model $entity */
        $entity = new $this->entityClass();
        return $entity->getTable();
    }

    /**
     * @return DatabaseManager
     */
    protected function getConnection() : DatabaseManager
    {
        return app('db');
    }
}