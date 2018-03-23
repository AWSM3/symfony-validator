<?php
/**
 * @filename: EntityNotExists.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator\Constraints;

/**
 * Class EntityNotExists
 * @package Awsm3\Symfony\Validator\Constraints
 */
class EntityNotExists extends EntityExists
{
    /** @var string */
    public $message = 'Entity already exists.';
}