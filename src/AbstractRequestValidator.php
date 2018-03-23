<?php
/**
 * @filename: AbstractRequestValidator.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator;

/** @uses */
use Awsm3\Symfony\Validator\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractRequestValidator
 * @package Awsm3\Symfony\Validator
 */
abstract class AbstractRequestValidator extends AbstractValidator
{
    /**
     * @param Request $request
     *
     * @throws InvalidFormException
     * @return array
     */
    public function validate($request)
    {
        return parent::validate($request->request->all());
    }
}