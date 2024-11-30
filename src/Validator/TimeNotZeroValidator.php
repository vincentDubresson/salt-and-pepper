<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TimeNotZeroValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /** @var TimeNotZero $constraint */
        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof \DateTimeInterface) {
            return;
        }

        if ((int) $value->format('H') === 0 && (int) $value->format('i') === 0) {
            $this->context->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
