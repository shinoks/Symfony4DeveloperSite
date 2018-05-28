<?php
namespace App\Form;

use App\Entity\RecruitmentStatus;
use App\Entity\RecruitmentUserStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecruitmentUsersAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', EntityType::class, array(
                'label'=>'status',
                'class' => RecruitmentUserStatus::class,
                'choice_label' => 'name',
            ))
            ->add('declaredAmount',IntegerType::class,[
                'label' => 'declared_amount'
            ])
            ->add('payedAmount',IntegerType::class,[
                'label' => 'payed_amount'
            ])
            ->add('payedDate', DateType::class, array(
                'label'=>'payed_date',
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('endDate', DateType::class, array(
                'label'=>'end_date',
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('investmentPeriod',IntegerType::class,[
                'label' => 'investment_period'
            ])
            ->add('interest',PercentType::class,[
                'scale' => 2,
                'type' => 'integer',
                'label' => 'interest'
            ])

            ->add('save', SubmitType::class, ['label' => 'make_an_offer']);
    }
}
