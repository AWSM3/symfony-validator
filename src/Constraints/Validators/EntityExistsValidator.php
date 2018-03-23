<?php
/**
 * @filename: EntityExistsValidator.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator\Constraints\Validators;

/** @uses */
use Awsm3\Symfony\Validator\Constraints\EntityExists;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class EntityExistsValidator
 * @package Awsm3\Symfony\Validator\Constraints\Validators
 */
class EntityExistsValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * EntityExistsValidator constructor.
     *
     * @param ContainerInterface $container
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     * @param EntityExists $constraint
     *
     * @throws ValidatorException
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EntityExists) {
            throw new UnexpectedTypeException($constraint, EntityExists::class);
        }

        try {
            /** @throws ValidatorException */
            $this->checkEntityExists($value, $constraint);
        } catch (ValidatorException $e) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(EntityExists::ENTITY_EXISTS_ERROR)
                ->addViolation();
        }
    }

    /**
     * @param $value
     * @param EntityExists $constraint
     *
     * @throws ValidatorException if entity not exists
     * @return void
     */
    protected function checkEntityExists($value, EntityExists $constraint)
    {
        /** @var EntityRepository $repository */
        $repository = $this->entityManager->getRepository($constraint->entityClass);

        $criteria = Criteria::create();
        if (is_array($constraint->property)) {
            /** Если полей, по которым нужно найти юзера несколько */
            foreach ($constraint->property as $property) {
                $criteria->orWhere(
                    Criteria::expr()->eq($property, $value)
                );
            }
        } else {
            /** Если указано одно конкретное поле */
            $criteria->where(
                Criteria::expr()->eq($constraint->property, $value)
            );
        }
        $exists = $repository->matching($criteria)->count() > 0;

        if (!$exists) {
            throw new ValidatorException($constraint->message);
        }
    }
}