<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BankAccountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if($value){
            $iNRB = str_replace(' ', '', $value);
            if(strlen($iNRB) != 26){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();

                return false;
            }

            $aWagiCyfr = array(1, 10, 3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51, 25, 56, 75, 71, 31, 19, 93, 57);

            $iNRB = $iNRB.'2521';
            $iNRB = substr($iNRB, 2).substr($iNRB, 0, 2);
            $iSumaCyfr = 0;
            for($i = 0; $i < 30; $i++){
                $b = 29-$i;
                $iSumaCyfr += $iNRB[$b] * $aWagiCyfr[$i];
            }

            if ($iSumaCyfr % 97 != 1)
            {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
                return false;
            }
        }

        return true;
    }
}
