<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PeselValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if($value){
            if (!preg_match('/^[0-9]{11}$/',$value))
            {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
            }

            $arrSteps = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
            $intSum = 0;
            for ($i = 0; $i < 10; $i++)
            {
                $intSum += $arrSteps[$i] * $value[$i];
            }
            $int = 10 - $intSum % 10;
            $intControlNr = ($int == 10)?0:$int;
            if ($intControlNr != $value[10])
            {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
            }
        }
    }
}
