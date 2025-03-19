<?php

namespace App\Validator;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UsernameValidator extends ConstraintValidator
{

    function __construct(
        private readonly Security $security
    ){

    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Username $constraint */

        // TODO: Add username based validation;
        if ($value === $this->security->getUser()->getUserIdentifier()) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation()
        ;
    }
}
