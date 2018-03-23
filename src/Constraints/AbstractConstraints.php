<?php
/**
 * @filename: AbstractConstraints.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator\Constraints;

/** @uses */
use Symfony\Component\Validator\Constraint;

/**
 * Class AbstractConstraints
 * @package Awsm3\Symfony\Validator\Constraints
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class AbstractConstraints extends Constraint
{
    /**
     * Returns the name of the class that validates this constraint.
     *
     * By default, this is the fully qualified name of the constraint class
     * suffixed with "Validator". You can override this method to change that
     * behaviour.
     *
     * @return string
     * @throws \ReflectionException
     */
    public function validatedBy()
    {
        $className = (new \ReflectionClass($this))->getShortName();
        return __NAMESPACE__.'\Validators\\'.$className.'Validator';
    }
}
