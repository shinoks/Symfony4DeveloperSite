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
        ->add('email',EmailType::class,['label'=>'email'])
        ->add('password',PasswordType::class, ['label'=>'password','required' => false,'empty_data'=> $builder->getData()->getPassword()])
        ->add('phone',TelType::class,['label'=>'phone'])
        ->add('firstName',TextType::class,['label'=>'first_name'])
        ->add('lastName',TextType::class,['label'=>'last_name'])
        ->add('pesel',NumberType::class,['label'=>'pesel'])
        ->add('idNumber',TextType::class,['label'=>'id_number'])
        ->add('birthDate',BirthdayType::class,[
            'label'=>'birth_date',
            'placeholder' => 'Wybierz datę'
        ])
        ->add('zipCode',TextType::class,['label'=>'zip_code'])
        ->add('address',TextType::class,['label'=>'address'])
        ->add('city',TextType::class,['label'=>'city'])
        ->add('roles',ChoiceType::class, [
            'label'=>'roles',
            'multiple' => true,
                    'expanded' => true,
                    'choices' => [
            'Użytkownik' => 'ROLE_USER'
            ]])
        ->add('regulations',CheckboxType::class, ['label'=>'regulations','required' => true ])
        ->add('isActive',CheckboxType::class, ['label'=>'is_active','required' => false ])
        ->add('isEnabledByAdmin',CheckboxType::class, ['label'=>'is_enabled_by_admin','required' => false ])

        ->add('save', SubmitType::class);
    }
}
