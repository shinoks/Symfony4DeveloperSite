<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title',TextType::class,['label'=>'title'])
        ->add('email',EmailType::class,['label'=>'email'])
        ->add('phone',TextType::class,['label'=>'phone'])
        ->add('address',TextType::class,['label'=>'address'])

        ->add('save', SubmitType::class);
    }
}
