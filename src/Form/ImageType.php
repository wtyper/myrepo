<?php
namespace App\Form;
use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' =>'image',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Image([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Please upload a valid format',
                    ])
                ],
                'attr' => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple'
                ]
            ])
            ->add('alt');
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}