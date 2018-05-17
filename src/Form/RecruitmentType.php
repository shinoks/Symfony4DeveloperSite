<?php
namespace App\Form;

use App\Entity\RecruitmentStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecruitmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'name'
            ])
            ->add('desiredAmount',MoneyType::class,[
                'currency' => 'PLN',
                'label' => 'desired_amount'
            ])
            ->add('investmentPeriod',IntegerType::class,[
                'label' => 'investment_period'
            ])
            ->add('interest',PercentType::class,[
                'scale' => 2,
                'type' => 'integer',
                'label' => 'interest'
            ])
            ->add('investmentType',TextType::class,[
                'label' => 'investment_type'
            ])
            ->add('rooms',IntegerType::class,[
                'label' => 'rooms'
            ])
            ->add('city',TextType::class,[
                'label' => 'city'
            ])
            ->add('status', EntityType::class, array(
                'label'=>'status',
                'class' => RecruitmentStatus::class,
                'choice_label' => 'name',
            ))
            ->add('paymentTime', DateType::class, array(
                'label'=>'payment_time',
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('isActive',ChoiceType::class,[
                'label'=>'is_active',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Wyłączony' => '0',
                    'Włączony' => '1'
                ]
            ])
            ->add('content',TextareaType::class,[
                'label' => 'content'
            ])
            ->add('save', SubmitType::class, ['label' => 'add']);
    }
}
