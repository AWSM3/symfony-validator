<?php
/**
 * @filename: EntityNotExistsValidator.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator\Constraints\Validators;

/** @uses */
use Awsm3\Symfony\Validator\Constraints\EntityExists;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class EntityNotExistsValidator
 * @package Awsm3\Symfony\Validator\Constraints\Validators
 */
class EntityNotExistsValidator extends EntityExistsValidator
{
    /**
     * {@inheritdoc}
     */
    protected function checkEntityExists($value, EntityExists $constraint)
    {
        try {
            parent::checkEntityExists($value, $constraint);
        } catch (ValidatorException $e) {
            /** Entity not exists */
            return;
        }

        /** Entity exists */
        throw new ValidatorException($constraint->message);
    }
}