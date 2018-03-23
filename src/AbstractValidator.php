<?php
/**
 * @filename: AbstractValidator.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator;

/** @uses */
use Awsm3\Symfony\Validator\Exception\InvalidFormException;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class AbstractValidator
 * @package Awsm3\Symfony\Validator
 */
abstract class AbstractValidator
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /**
     * AbstractRequestValidator constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param array $data
     *
     * @throws InvalidFormException
     * @return array
     */
    public function validate($data)
    {
        $formBuilder = $this->formFactory->createBuilder(
            FormType::class,
            null,
            ['csrf_protection' => false]
        );
        $form = $this
            ->buildForm($formBuilder)
            ->getForm();
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            return $form->getData();
        }

        throw new InvalidFormException('Форма невалидна', $form);
    }

    /**
     * @param FormBuilderInterface $formBuilder
     *
     * @return FormBuilderInterface
     */
    abstract protected function buildForm(FormBuilderInterface $formBuilder): FormBuilderInterface;
}