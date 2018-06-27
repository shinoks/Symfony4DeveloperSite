<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecruitmentStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label'=>'name'])
            ->add('isMailedToAdmin',CheckboxType::class, ['label'=>'is_mailed_to_admin','required' => false ])
            ->add('mailAdminTemplate',TextType::class,['label'=>'mail_admin_template','required' => false])
            ->add('isMailedToUsers',CheckboxType::class, ['label'=>'is_mailed_to_users','required' => false ])
            ->add('mailUsersTemplate',TextType::class,['label'=>'mail_users_template','required' => false])
            ->add('isVisibleToUsers',CheckboxType::class, ['label'=>'is_visible_to_users','data' => true,'required' => false ])
            ->add('isActive',CheckboxType::class, ['label'=>'is_active','data' => true, 'required' => false ])

            ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
