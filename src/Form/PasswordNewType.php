<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PasswordNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', RepeatedType::class, array(
        'type' => PasswordType::class,
        'invalid_message' => 'Podane hasła muszą być identyczne.',
        'options' => array('attr' => array('class' => 'password-field')),
        'required' => true,
        'first_options'  => array('label' => 'password.new'),
        'second_options' => array('label' => 'password.repeat'),
        ))

        ->add('save', SubmitType::class);
    }
}
