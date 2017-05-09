<?php

namespace AppBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationStep3Type
 */
class RegistrationStep3Type extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('teacherSkills', CollectionType::class, array(
            'entry_type' => SkillsType::class
        ))
            ->add('description', TextareaType::class)

            ->remove('username')
            ->remove('email')
            ->remove('plainPassword');
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
        return 'app_user_registration_step_3';
    }
}