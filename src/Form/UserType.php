<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email',TextType::class,['label'=>'email','required' => true])
        ->add('password',PasswordType::class,['label'=>'password.password','required' => true])
        ->add('firstName',TextType::class,['label'=>'first_name','required' => true])
        ->add('lastName',TextType::class,['label'=>'last_name','required' => true])
        ->add('phone',TelType::class,['label'=>'phone','required' => true])
        ->add('gender',ChoiceType::class, [
                'label'=>'gender',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Pani' => 'f',
                    'Pan' => 'm'
                ],
                'required' => true
        ])
        ->add('birthDate',BirthdayType::class,[
            'label'=>'birth_date',
            'placeholder' => 'Wybierz datę',
            'required' => true
        ])
        ->add('regulations',CheckboxType::class, ['label'=>'regulations','required' => true ])
        ->add('marketingRegulations',CheckboxType::class, ['label'=>'marketing_regulations','required' => false ])

        ->add('save', SubmitType::class, ['label' => 'register']);
    }
}
