<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 27/12/2016
 * Time: 22:03
 */

namespace AppBundle\Form;
use AppBundle\Entity\Skills;
use AppBundle\Entity\user;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UsertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
        ;
        $builder->add('skills', CollectionType::class, array(
            'entry_type' => SkillsType::class
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Skills::class,
        ));
    }
}