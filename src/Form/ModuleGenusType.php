<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModuleGenusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class,['label'=>'name'])
        ->add('type',TextType::class,['label'=>'type'])
        ->add('content',TextareaType::class,['label'=>'content','required' => false])
        ->add('template',TextType::class,['label'=>'template'])

        ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
