<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Genre;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('author', EntityType::class,[
                'class'=>Author::class,
                'choice_label'=> static function ($author, $_, $__) {
                 /** @var Author $author */
                 return $author->getName() . ' ' . $author->getLastName();
                }
                ])
            ->add('genres', EntityType::class,[
                'class'=>Genre::class,
                'choice_label' => 'name'])
            ->add('yearOfPublishment')
            ->add('countryOfPublishment', CountryType::class)
            ->add('availability');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
