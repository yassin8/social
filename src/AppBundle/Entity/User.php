<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="social_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="teacher")
     */
    protected $teacherLessons;

    /**
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="student")
     */
    protected $studentLessons;

    /**
     * @ORM\OneToMany(targetEntity="Skills", mappedBy="teacher")
     */
    protected $teacherSkills;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getTeacherLessons()
    {
        return $this->teacherLessons;
    }

    /**
     * @param mixed $teacherLessons
     */
    public function setTeacherLessons($teacherLessons)
    {
        $this->teacherLessons = $teacherLessons;
    }

    /**
     * @return mixed
     */
    public function getStudentLessons()
    {
        return $this->studentLessons;
    }

    /**
     * @param mixed $studentLessons
     */
    public function setStudentLessons($studentLessons)
    {
        $this->studentLessons = $studentLessons;
    }

    /**
     * Add teacherLesson
     *
     * @param \AppBundle\Entity\Lesson $teacherLesson
     *
     * @return User
     */
    public function addTeacherLesson(\AppBundle\Entity\Lesson $teacherLesson)
    {
        $this->teacherLessons[] = $teacherLesson;

        return $this;
    }

    /**
     * Remove teacherLesson
     *
     * @param \AppBundle\Entity\Lesson $teacherLesson
     */
    public function removeTeacherLesson(\AppBundle\Entity\Lesson $teacherLesson)
    {
        $this->teacherLessons->removeElement($teacherLesson);
    }

    /**
     * Add studentLesson
     *
     * @param \AppBundle\Entity\Lesson $studentLesson
     *
     * @return User
     */
    public function addStudentLesson(\AppBundle\Entity\Lesson $studentLesson)
    {
        $this->studentLessons[] = $studentLesson;

        return $this;
    }

    /**
     * Remove studentLesson
     *
     * @param \AppBundle\Entity\Lesson $studentLesson
     */
    public function removeStudentLesson(\AppBundle\Entity\Lesson $studentLesson)
    {
        $this->studentLessons->removeElement($studentLesson);
    }

    /**
     * Add teacherSkill
     *
     * @param \AppBundle\Entity\Skills $teacherSkill
     *
     * @return User
     */
    public function addTeacherSkill(\AppBundle\Entity\Skills $teacherSkill)
    {
        $this->teacherSkills[] = $teacherSkill;

        return $this;
    }

    /**
     * Remove teacherSkill
     *
     * @param \AppBundle\Entity\Skills $teacherSkill
     */
    public function removeTeacherSkill(\AppBundle\Entity\Skills $teacherSkill)
    {
        $this->teacherSkills->removeElement($teacherSkill);
    }

    /**
     * Get teacherSkills
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeacherSkills()
    {
        return $this->teacherSkills;
    }
}
