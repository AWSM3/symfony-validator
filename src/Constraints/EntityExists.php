<?php
/**
 * @filename: EntityExists.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator\Constraints;

/** @uses */
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Class EntityExists
 * @package Awsm3\Symfony\Validator\Constraints
 */
class EntityExists extends AbstractConstraints
{
    const
        ENTITY_EXISTS_ERROR = 'y68h4641y86168y41h4rsw78';

    /** @var array */
    protected static $errorNames = [
        self::ENTITY_EXISTS_ERROR => 'ENTITY_EXISTS_ERROR',
    ];

    /** @var string */
    public $message = 'Entity not exists.';
    /** @var string */
    public $entityClass;
    /** @var string */
    public $property;

    /**
     * {@inheritdoc}
     */
    public function __construct($options = null)
    {
        if (null !== $options && !is_array($options)) {
            throw new MissingOptionsException(
                sprintf('Either option "entityClass" or "property" must be given for constraint %s', __CLASS__),
                ['entityClass', 'property']
            );
        }

        parent::__construct($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}