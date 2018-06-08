<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BankAccount extends Constraint
{
    public $message = 'Podany nr konta bankowego "{{ string }}" nie jest prawidłowy.';
}
