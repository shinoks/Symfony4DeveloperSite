<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OpinionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title',TextType::class,['label'=>'opinions.title','required' => true])
        ->add('text',TextareaType::class,['label'=>'opinions.text','required' => true])
        ->add('nickname',TextType::class,['label'=>'opinions.nickname','required' => true])

        ->add('save', SubmitType::class, ['label' => 'opinions.add']);
    }
}
