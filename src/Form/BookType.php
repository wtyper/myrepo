<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Genre;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Validator\Constraints\Image;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('author', EntityType::class, [
                'class'=>Author::class,
                'choice_label'=> static function ($author) {
                 /** @var Author $author */
                    return $author->getName() . ' ' . $author->getLastName();
                }])
            ->add('genre', EntityType::class, [
                'class'=>Genre::class,
                'choice_label' => 'name'])
            ->add('yearOfPublishment', NumberType::class)
            ->add('countryOfPublishment', CountryType::class)
            ->add('availability')
            ->add('cover', FileType::class, [
                'label' =>'cover',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'maxHeight' => 300,
                        'maxWidth' => 300,
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
                'attr' => [
                    'accept' => 'image/*',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
