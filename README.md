# SymfonyValidator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$ composer require awsm3/symfony-validator
```

## Usage
#### Request validation class
``` php
<?php
declare(strict_types=1);
 
namespace App\Validator;
 
use Awsm3\Validator\Symfony\AbstractRequestValidator;
use Awsm3\Symfony\Validator\Field\BaseTypeFields;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
 
class CustomValidator extends AbstractRequestValidator
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function validate($request): array
    {
        $formData = parent::validate($request);

        return $formData;
    }
 
    /**
     * Build form with validation rules
     *
     * @param FormBuilderInterface $formBuilder
     *
     * @return FormBuilderInterface
     */
    protected function buildForm(FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder
            // Not required 'Email' field
            // @see Awsm3\Symfony\Validator\Field\BaseTypeFields for field constraints examples
            ->add(
                'email', TextType::class, [
                'constraints' => BaseTypeFields::emailConstraints(),
            ]);
    }
}
```

#### Validate request
``` php
<?php
declare(strict_types=1);
 
namespace App\Service;
 
use Awsm3\Validator\Symfony\Exception\InvalidFormException;
use App\Validator\CustomValidator;
use Symfony\Component\HttpFoundation\Request;
 
/**
 * Class VideoCompiler
 * @package App\Service
 */
class SomeService
{
    /** @var CustomValidator */
    private $customValidator;
 
    public function __construct(CustomValidator $customValidator)
    {
        $this->customValidator = $customValidator;
    }
 
    /**
     * @param Request $request
     *
     * @throws InvalidFormException
     * @return string
     */
    public function someServiceMethod(Request $request): string
    {
        try {
            $validatedFormData = $this->customValidator->validate($request);
        } catch (InvalidFormException $e) {
            throw $e;
        }
        
        return 'Request is valid';
    }
}
```

## Security

If you discover any security related issues, please using the issue tracker.

## Credits

- [AWSM3][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/awsm3/symfony-validator.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/awsm3/symfony-validator.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/awsm3/symfony-validator
[link-downloads]: https://packagist.org/packages/awsm3/symfony-validator
[link-author]: https://github.com/awsm3
[link-contributors]: ../../contributors