<?php
/**
 * @filename: BaseTypeFields.php
 */
declare(strict_types=1);

/** @namespace */
namespace Awsm3\Symfony\Validator\Field;

/** @uses */
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class BaseTypeFields
 * @package Awsm3\Symfony\Validator\Field
 */
class BaseTypeFields
{
    /**
     * @param bool $notBlank
     * @param int  $min
     * @param int  $max
     *
     * @return array
     */
    public static function stringConstraints($notBlank = false, $min = 1, $max = 255): array
    {
        $constraints = [
            new Type('string'),
            new Length(compact('min', 'max')),
        ];

        if ($notBlank) {
            $constraints[] = new NotBlank();
        }

        return $constraints;
    }

    /**
     * @param bool $notBlank
     *
     * @return array
     */
    public static function emailConstraints($notBlank = false): array
    {
        $constraints = [
            new Email()
        ];

        if ($notBlank) {
            $constraints[] = new NotBlank();
        }

        return $constraints;
    }

    /**
     * @param      $propertyName
     * @param bool $notBlank
     *
     * @return array
     */
    public static function jsonConstraints($propertyName, $notBlank = false): array
    {
        $constraints = [
            new Type('string'),
            new Callback(
                [
                    'callback' => function ($value, ExecutionContextInterface $context) use ($propertyName) {
                        if (empty($value)) {
                            return;
                        }
                        try {
                            (new JsonDecode(true))->decode($value, JsonEncoder::FORMAT);
                        } catch (\Exception $e) {
                            $context
                                ->buildViolation('Некорректное значение поля, ожидается сериализованный JSON-объект')
                                ->atPath($propertyName)
                                ->addViolation();
                        }
                    }
                ])
        ];

        if ($notBlank) {
            $constraints[] = new NotBlank();
        }

        return $constraints;
    }
}