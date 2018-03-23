<?php
/**
 * @filename: InvalidFormException.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator\Exception;

/** @uses */
use Symfony\Component\Form\FormInterface;

/**
 * Class InvalidFormException
 * @package Awsm3\Symfony\Validator\Exception
 */
class InvalidFormException extends \RuntimeException
{
    /** @var FormInterface */
    private $form;

    /**
     * InvalidFormException constructor.
     *
     * @param string $message
     * @param FormInterface $form
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", FormInterface $form, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * @param FormInterface|null $form
     *
     * @return array
     */
    public function getFormErrors(FormInterface $form = null): array
    {
        $form = $form ?? $this->form;
        $formErrors = [];

        foreach ($form->getErrors() as $error) {
            $formErrors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getFormErrors($childForm)) {
                    $formErrors[$childForm->getName()] = count($childErrors) > 1 ? $childErrors : reset($childErrors);
                }
            }
        }


        return $formErrors;
    }
}