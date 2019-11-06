<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->add('originCountry', CountryType::class)
            ->add('dateOfBirth', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => date('Y'),
                ]])
            ->add('dateOfDeath', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => date('Y'),
                ],
            'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
