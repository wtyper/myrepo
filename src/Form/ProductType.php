<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('productCategory', EntityType::class, [
                'class' => ProductCategory::class,
                'query_builder' => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.name');
                },
                'choice_label' => 'name'])
            ->add('cover', FileType::class, [
                'label' => 'cover',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Please upload a valid size of image',
                    ])
                ],
                'attr' => [
                    'accept' => 'image/*',
                ]
            ]);
    }
}
