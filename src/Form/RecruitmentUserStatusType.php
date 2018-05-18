<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecruitmentUserStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label'=>'name'])
            ->add('isFvGenerated',CheckboxType::class, ['label'=>'is_fv_generated','required' => false ])
            ->add('isFvMailed',CheckboxType::class, ['label'=>'is_fv_mailed','required' => false ])
            ->add('isActive',CheckboxType::class, ['label'=>'is_active','required' => false ])

            ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
