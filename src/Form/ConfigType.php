<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        ->add('logoMain',TextType::class,['label'=>'logo_for_main_site'])
        ->add('logoAdmin',TextType::class,['label'=>'logo_for_admin_site'])
        ->add('regulationsUrl',TextType::class,['label'=>'regulations_url'])
        ->add('privacyPolicyUrl',TextType::class,['label'=>'privacy_policy_url'])
        ->add('bankAccount',TextType::class,['label'=>'bank_account', 'required' => false])
        ->add('description',TextareaType::class,['label'=>'description'])
        ->add('keywords',TextareaType::class,['label'=>'keywords'])
        ->add('footer',TextType::class,['label'=>'footer'])

        ->add('save', SubmitType::class);
    }
}
