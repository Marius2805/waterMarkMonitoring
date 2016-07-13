<?php
namespace App\General;

/**
 * Class EntityNotFoundException
 * @package App\General
 */
class EntityNotFoundException extends \RuntimeException
{
    public function __construct(string $entityClass, $requestedKey)
    {
        $message = 'Unable to find ' . $entityClass . ' by Key ' . $requestedKey . '.';
        parent::__construct($message);
    }
}