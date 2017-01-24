<?php

namespace AppBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class RegistrationType
 */
class RegistrationType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, array(
                'choices' => array(
                    'Mr' => 'f',
                    'M' => 'm'
                ),
                'required'    => false,
                'placeholder' => 'Civility',
                'empty_data'  => null
            ))
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('birthDate', BirthdayType::class)
            ->add('country', CountryType::class)
            ->add('city', TextType::class)
            ->add('zipCode', TextType::class)
            ->add('address', TextType::class)
            ->add('phone', TextType::class)
            ->add('username')
            ->add('email', EmailType::class)
            ->add('teacherSkills', CollectionType::class, array(
                'entry_type' => SkillsType::class
            ))
            ->add('description', TextareaType::class)
            ->remove('username');

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $user = $form->getData();
            $user->setUsername($user->getEmail());
            $form->setData($user);
        });
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return RegistrationFormType::class;
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}