<?php
namespace App\Form;

use App\Entity\Menu;
use App\Entity\ModuleGenus;
use App\Entity\ModulePosition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label'=>'name'])
            ->add('position', EntityType::class, array(
                'label'=>'position',
                'class' => ModulePosition::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false
            ))
            ->add('genus', EntityType::class, array(
                'label'=>'genus',
                'class' => ModuleGenus::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => false
            ))
            ->add('menus', EntityType::class, array(
                'label'=>'menus_position',
                'class' => Menu::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'expanded' => true

            ))
            ->add('sequence',IntegerType::class,[
                'label' => 'order',
                'required' => false
            ])
            ->add('variable',CollectionType::class,[
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
            ->add('isActive',CheckboxType::class, ['label'=>'is_active','required' => false ])

            ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
