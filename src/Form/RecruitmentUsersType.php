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
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecruitmentUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('declaredAmount',RangeType::class,[
                'label' => '',
                'attr' => array(
                    'min' => $options['data']->min,
                    'max' => $options['data']->max,
                    'step' => 10000,
                    'data-slider-min' => $options['data']->min,
                    'data-slider-max' => $options['data']->max,
                    'data-slider-step' => 10000,
                    'value' => $options['data']->max
                )
            ])

            ->add('save', SubmitType::class, ['label' => 'make_an_offer']);
    }
}
