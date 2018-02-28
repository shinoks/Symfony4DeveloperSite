<?php
namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class,['label'=>'name'])
        ->add('shortText',TextareaType::class,['label'=>'short_text', 'required' => false])
        ->add('text',TextareaType::class,['label'=>'text'])
        ->add('category', EntityType::class, array(
            'label'=>'category',
            'class' => Category::class,
            'choice_label' => 'name',
        ))
        ->add('image', FileType::class, array(
            'label' => 'main_image',
            'required' => false,
            'data_class' => null
        ))
        ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
