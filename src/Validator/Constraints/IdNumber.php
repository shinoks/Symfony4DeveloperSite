<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IdNumber extends Constraint
{
    public $message = 'Podany nr dowodu "{{ string }}" nie jest prawidłowy.';
}
