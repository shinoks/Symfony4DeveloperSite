<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('phone',TelType::class,['label'=>'phone','required' => true])
        ->add('pesel',NumberType::class,['label'=>'pesel'])
        ->add('idNumber',NumberType::class,['label'=>'id_number'])
        ->add('zipCode',TextType::class,['label'=>'zip_code'])
        ->add('address',TextType::class,['label'=>'address'])
        ->add('city',TextType::class,['label'=>'city'])
        ->add('bankAccount',TextType::class,['label'=>'bank_account'])

        ->add('save', SubmitType::class);
    }
}
