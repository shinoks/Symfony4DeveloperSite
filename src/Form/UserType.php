<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
        ->add('email',TextType::class,['label'=>'first_name'])
        ->add('password',PasswordType::class,['label'=>'password.password'])
        ->add('firstName',TextType::class,['label'=>'first_name'])
        ->add('lastName',TextType::class,['label'=>'last_name'])
        ->add('gender',ChoiceType::class, [
                'label'=>'gender',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Pani' => 'f',
                    'Pan' => 'm'
                ]])
        ->add('birthDate',BirthdayType::class,[
            'label'=>'birth_date',
            'placeholder' => 'Wybierz datę'
        ])
        ->add('regulations',CheckboxType::class, ['label'=>'regulations','required' => true ])
        ->add('marketingRegulations',CheckboxType::class, ['label'=>'marketing_regulations','required' => false ])

        ->add('save', SubmitType::class, ['label' => 'register']);
    }
}
