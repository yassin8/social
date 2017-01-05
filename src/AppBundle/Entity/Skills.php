<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skills
 *
 * @ORM\Table(name="skills")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SkillsRepository")
 */
class Skills
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="teacherSkills")
     * @ORM\JoinColumn(name="teacher_id_fk", referencedColumnName="id")
     */
    private $teacher;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="skills")
     * @ORM\JoinColumn(name="course_id_fk", referencedColumnName="id")
     */
    private $course;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Skills
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set teacher
     *
     * @param \AppBundle\Entity\User $teacher
     *
     * @return Skills
     */
    public function setTeacher(User $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \AppBundle\Entity\User
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return Skills
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \AppBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }
}
