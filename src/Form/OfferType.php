<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ammount',MoneyType::class,['label'=>'ammount','currency'=>'PLN'])
        ->add('period',ChoiceType::class,[
            'label'=>'period',
            'multiple' => false,
            'expanded' => true,
            'choices' => [
                '12 miesięcy' => '12',
                '24 miesiące' => '24'
            ]
        ])
        ->add('settlement',ChoiceType::class,[
            'label'=>'settlement',
            'multiple' => false,
            'expanded' => true,
            'choices' => [
                '6 miesięcy' => '6',
                '12 miesięcy' => '12',
                '24 miesiące' => '24'
            ]
        ])

        ->add('save', SubmitType::class, ['label' => 'add']);
    }
}
