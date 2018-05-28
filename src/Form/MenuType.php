<?php
namespace App\Form;

use App\Entity\Menu;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent', EntityType::class, [
                'label'=>'parent',
                'class' => Menu::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Choose an option'
            ])
            ->add('name',TextType::class,[
                'label' => 'name'
            ])
            ->add('href',TextType::class,[
                'label' => 'href',
                'required' => false
            ])
            ->add('article', EntityType::class, [
                'label'=>'article',
                'class' => Article::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option',
                'required' => false,
                'attr' => [
                        'placeholder' => 'Enter product name'
                    ]
            ])
            ->add('category', EntityType::class, [
                'label'=>'category',
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option',
                'required' => false
            ])
            ->add('type',ChoiceType::class,[
                'label'=>'type',
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'href' => 'href',
                    'article' => 'article',
                    'category' => 'category'
                ]])
            ->add('position',IntegerType::class,[
                'label' => 'position',
                'required' => false
            ])
            ->add('inFooter',CheckboxType::class,[
                'label' => 'footer_menu',
                'required' => false
            ])
            ->add('inBottom',CheckboxType::class,[
                'label' => 'bottom_menu',
                'required' => false
            ])
            ->add('inMain',CheckboxType::class,[
                'label' => 'main_menu',
                'required' => false
            ])

        ->add('save', SubmitType::class, ['label' => 'Zapisz']);
    }
}
