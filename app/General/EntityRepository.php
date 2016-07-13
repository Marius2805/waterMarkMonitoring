<?php
namespace App\General;
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

    public function save(Model $entity)
    {
        $entity->save();
        $this->addToCache($entity);
    }

    public function delete(Model $entity)
    {
        $this->removeFromCache($entity);
        $entity->delete();
    }

    abstract protected function getEntityClass() : string;

    protected function addToCache(Model $entity)
    {
        self::$cache[$this->getEntityClass()][$entity->getKey()] = $entity;
    }

    protected function removeFromCache(Model $entity)
    {
        unset(self::$cache[$this->getEntityClass()][$entity->getKey()]);
    }
}