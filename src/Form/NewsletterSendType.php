<?php
namespace App\Form;

use App\Entity\Newsletter;
use App\Entity\Recruitment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewsletterSendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('newsletter', EntityType::class, array(
                'label'=>'newsletter',
                'class' => Newsletter::class,
                'choice_label' => 'title',
                'empty_data' => null,
                'placeholder' => '---'
            ))
        ->add('newsletterUsers',ChoiceType::class,[
                'label'=>'is_active',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Dla użytkowników z inwestycji' => 'recruitment',
                    'Dla wszystkich użytkowników' => 'all_users',
                    'Dla użytkowników newslettera' => 'newsletter_users'
                ]
        ])
        ->add('recruitment', EntityType::class, array(
                'label'=>'recruitment',
                'class' => Recruitment::class,
                'choice_label' => 'name',
                'empty_data' => null,
                'placeholder' => '---',
            'required' => false
        ))

        ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
