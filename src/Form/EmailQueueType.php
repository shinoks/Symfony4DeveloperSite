<?php
namespace App\Form;

use App\Entity\Newsletter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmailQueueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class,['label'=>'name'])
        ->add('email',EmailType::class,['label'=>'email'])
        ->add('send',CheckboxType::class,['label'=>'send'])
        ->add('sendDate',DateType::class,[
            'label'=>'send_date',
            'required' => false
            ])
        ->add('newsletter', EntityType::class, array(
            'label'=>'newsletter',
            'class' => Newsletter::class,
            'choice_label' => 'title',
            'empty_data' => null,
            'placeholder' => '---'
        ))
        ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
