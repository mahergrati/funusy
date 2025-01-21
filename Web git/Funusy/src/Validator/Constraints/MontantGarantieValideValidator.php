<?php

namespace App\Validator\Constraints;


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MontantGarantieValideValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value < $constraint->montantCredit) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}