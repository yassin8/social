<?php

namespace AppBundle\Form;
use AppBundle\Entity\Course;
use AppBundle\Entity\Lesson;
use AppBundle\Repository\SkillsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\DateTime;

class LessonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->userId = $options['label'];
        $builder->add('course', EntityType::class, array(
            'class' => Course::class,
            'choice_label' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->innerJoin('c.skills', 's')
                    ->innerJoin('s.teacher', 't')
                    ->where('t.id = :id')
                    ->setParameter('id',$this->userId  );
            },
        ))
         ->add('date', DateTimeType::class, array('data' => new \DateTime()))
        ->add('address')
            ->add('description')
            ->add('save', SubmitType::class)

        ;


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Lesson::class,
        ));
    }
}