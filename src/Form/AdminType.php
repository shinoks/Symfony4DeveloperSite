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

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username',TextType::class,['label'=>'username'])
        ->add('password',PasswordType::class, ['label'=>'password','required' => false,'empty_data'=> $builder->getData()->getPassword()])
        ->add('email',EmailType::class,['label'=>'email'])
        ->add('firstName',TextType::class,['label'=>'first_name'])
        ->add('lastName',TextType::class,['label'=>'last_name'])
        ->add('roles',ChoiceType::class, [
            'label'=>'roles',
            'multiple' => true,
                    'expanded' => true,
                    'choices' => [
            'Admin' => 'ROLE_ADMIN',
            'Manager' => 'ROLE_MANAGER',
            ]])
        ->add('isActive',CheckboxType::class, ['label'=>'is_active','required' => false ])

        ->add('save', SubmitType::class, ['label' => 'Zapisz']);
    }
}
