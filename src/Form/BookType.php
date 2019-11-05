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

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('author', EntityType::class,[
                'class'=>Author::class,
        'query_builder' => static function (EntityRepository $er){
                return $er->createQueryBuilder('a')
                    ->orderBy('a.name')
                    ->orderBy('a.lastName');
        },
                'choice_label' => 'name'])
            ->add('genres', EntityType::class,[
        'class'=>Genre::class,
        'query_builder' => static function (EntityRepository $er){
            return $er->createQueryBuilder('g')
                ->orderBy('g.name');
        },
        'choice_label' => 'name'])
            ->add('yearOfPublishment')
            ->add('countryOfPublishment')
            ->add('availability');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
