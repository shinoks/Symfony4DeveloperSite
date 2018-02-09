<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username',TextType::class)
        ->add('password',PasswordType::class, array('required' => false,'empty_data'=> $builder->getData()->getPassword()))
        ->add('email',EmailType::class)
        ->add('firstName',TextType::class)
        ->add('lastName',TextType::class)
        ->add('roles',ChoiceType::class, [
        'multiple' => true,
                'expanded' => true,
                'choices' => [
        'Użytkownik' => 'ROLE_USER'
        ]])
        ->add('isActive',CheckboxType::class, array('required' => false ))

        ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
