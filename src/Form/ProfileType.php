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

class ProfileType extends AbstractType
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
        $constraintsOptions = array(
            'message' => 'fos_user.current_password.invalid',
        );
        if (!empty($options['validation_groups'])) {
            $constraintsOptions['groups'] = array(reset($options['validation_groups']));
        }
        $builder->add('current_password', PasswordType::class, array(
            'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => array(
                new NotBlank(),
                new UserPassword($constraintsOptions),
            ),
            'attr' => array(
                'autocomplete' => 'current-password',
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
            ->add('username', null, ['label' => 'form.username', 'translation_domain' => 'FOSUserBundle'])
            ->add('email', EmailType::class, ['label' => 'form.email', 'translation_domain' => 'FOSUserBundle'])
            ->add('locale', ChoiceType::class, [
                'choices' => ['🇬🇧English' => 'en', '🇵🇱Polski' => 'pl'],
                'label' => $this->translator->trans('profile.edit.locale')
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