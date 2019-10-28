<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \App\Form\ProductCategoryType;
use Doctrine\ORM\ProductCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('productCategory', EntityType::class, [
                'class' => ProductCategory::class,
                'choice_label' => 'category'])
            ->add('dateOfCreation')
            ->add('dateOfLastModification');
        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
