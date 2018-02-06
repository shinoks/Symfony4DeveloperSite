<?php
namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class)
        ->add('text',TextareaType::class)
        ->add('category', EntityType::class, array(
            'class' => Category::class,
            'choice_label' => 'name',
        ))
        ->add('save', SubmitType::class, array('label' => 'Zapisz'));
    }
}
