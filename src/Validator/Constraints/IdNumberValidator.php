<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IdNumberValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if($value){
            if(strlen($value)!=9){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
            } else{
                $identity_card = strtoupper($value);
                $def_value = ['0'=>0,'1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,
                    'A'=>10, 'B'=>11, 'C'=>12, 'D'=>13, 'E'=>14, 'F'=>15, 'G'=>16, 'H'=>17, 'I'=>18, 'J'=>19,
                    'K'=>20, 'L'=>21, 'M'=>22, 'N'=>23, 'O'=>24, 'P'=>25, 'Q'=>26, 'R'=>27, 'S'=>28, 'T'=>29,
                    'U'=>30, 'V'=>31, 'W'=>32, 'X'=>33, 'Y'=>34, 'Z'=>35];
                $importance = [7,  3,  1,  0,  7,  3,  1,  7,  3];
                $identity_card_sum = 0;

                for($i=0;$i<9;$i++){
                    if($i<3 && $def_value[$identity_card[$i]]<10){
                        $this->context->buildViolation($constraint->message)
                            ->setParameter('{{ string }}', $value)
                            ->addViolation();
                    } elseif($i>2 && $def_value[$identity_card[$i]]>9){
                        $this->context->buildViolation($constraint->message)
                            ->setParameter('{{ string }}', $value)
                            ->addViolation();
                    }
                    $identity_card_sum += ((int)$def_value[$identity_card[$i]]) * $importance[$i];
                }
                if($identity_card_sum%10 != $identity_card[3]  ){
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ string }}', $value)
                        ->addViolation();
                }
            }
        }
    }
}
