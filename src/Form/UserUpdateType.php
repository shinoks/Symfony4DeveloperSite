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

class UserUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('phone',TelType::class,['label'=>'phone','required' => true])
        ->add('firstName',TextType::class,['label'=>'first_name','required' => true])
        ->add('lastName',TextType::class,['label'=>'last_name','required' => true])
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
        ->add('pesel',NumberType::class,['label'=>'pesel','required' => false])
        ->add('idNumber',TextType::class,['label'=>'id_number','required' => false])
        ->add('zipCode',TextType::class,['label'=>'zip_code','required' => false])
        ->add('address',TextType::class,['label'=>'address','required' => false])
        ->add('city',TextType::class,['label'=>'city','required' => false])
        ->add('bankAccount',TextType::class,['label'=>'bank_account','required' => false])
        ->add('regulations',CheckboxType::class, ['label'=>'regulations','required' => true ])
        ->add('marketingRegulations',CheckboxType::class, ['label'=>'marketing_regulations','required' => false ])

        ->add('save', SubmitType::class);
    }
}
