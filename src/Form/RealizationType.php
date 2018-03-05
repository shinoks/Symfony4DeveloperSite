<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RealizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class,['label'=>'name'])
        ->add('mainImage', TextType::class, array(
                'label' => 'main_image',
                'required' => false
            ))
        ->add('folderWithImages',TextType::class,['label'=>'folder_with_images'])
        ->add('sellingPrice',IntegerType::class,['label'=>'selling_price'])
        ->add('currency',ChoiceType::class,[
            'label'=>'currency',
            'multiple' => false,
            'expanded' => true,
            'choices' => [
                'PLN' => 'PLN'
            ]])
        ->add('volume',TextType::class,['label'=>'volume'])
        ->add('city',TextType::class,['label'=>'city'])
        ->add('rooms',IntegerType::class,['label'=>'rooms'])
        ->add('yardage',IntegerType::class,['label'=>'yardage'])
        ->add('basic',CollectionType::class,[
                'entry_type'    => TextType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype'    => true,
                'by_reference' => false,
                'required' => false,
                'attr'         => [
                    'class' => "basic-collection",
                ],
            ])
        ->add('media',CollectionType::class,[
            'entry_type'    => TextType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'prototype'    => true,
            'by_reference' => false,
            'required' => false,
            'attr'         => [
                'class' => "media-collection",
            ],
        ])
        ->add('security',CollectionType::class,[
            'entry_type'    => TextType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'prototype'    => true,
            'by_reference' => false,
            'required' => false,
            'attr'         => [
                'class' => "security-collection",
            ],
        ])
            ->add('additionalInfo',CollectionType::class,[
                'entry_type'    => TextType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype'    => true,
                'by_reference' => false,
                'required' => false,
                'attr'         => [
                    'class' => "media-collection",
                ],
            ])

        ->add('description',TextareaType::class,['label' => 'description','required' => false])

        ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
