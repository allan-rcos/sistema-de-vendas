<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UsernameValidator extends ConstraintValidator
{

    function __construct(
        # private SecurityContext $securityContext
    ){

    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Username $constraint */

        // TODO: Add username based validation;
        if (null === $value || '' === $value) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation()
        ;
    }
}
