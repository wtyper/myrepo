<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserType extends AbstractType
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * ProfileType constructor.
     * @param TranslatorInterface $translator
     * @param string $class
     */
    public function __construct(TranslatorInterface $translator, string $class = User::class)
    {
        $this->class = $class;
        $this->translator = $translator;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildUserForm($builder, $options);
        $constraintsOptions = array($this->translator->trans('Passwords dont match'));
        if (!empty($options['validation_groups'])) {
            $constraintsOptions['groups'] = array(reset($options['validation_groups']));
        }
        $builder->add('current_password', PasswordType::class, array(
            'label' => $this->translator->trans('current_password'),
            'mapped' => false,
            'constraints' => array(
                new NotBlank(),
                new UserPassword($constraintsOptions),
            ),
            'attr' => array(
                'autocomplete' => 'current_password',
            ),
        ));
    }
    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Your username', null, [
                'label'  => $this->translator->trans('Your username')])
            ->add('Your email', EmailType::class,[
                'label' => $this->translator->trans('Your email')])
            ->add('locale', ChoiceType::class, [
                'choices' => ['🇬🇧English' => 'en', '🇵🇱Polski' => 'pl'],
                'label' => $this->translator->trans('locale')
            ]);
    }
    // BC for SF < 3.0
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'csrf_token_id' => 'profile',
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fos_user_profile';
    }
}