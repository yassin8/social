<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="social_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
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
     * @ORM\Column(name="linkedin_id", type="string", length=50, nullable=true)
     */
    protected $linkedInId;

    /**
     * @var string
     *
     * @ORM\Column(name="civility", type="string", length=50, nullable=true)
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=50, nullable=true)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="teacher")
     */
    protected $teacherLessons;

    /**
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="student")
     */
    protected $studentLessons;

    /**
     * @ORM\OneToMany(targetEntity="Skills", mappedBy="teacher", cascade={"persist", "remove"})
     */
    protected $teacherSkills;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="teacher")
     */
    protected $teacherReviews;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="student")
     */
    protected $studentReviews;

    /**
     * @ORM\OneToMany(targetEntity="Position", mappedBy="user")
     */
    private $positions;

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

    /**
     * Set civility
     *
     * @param string $civility
     *
     * @return User
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set city
     *
     * @param string
     *
     * @return User
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    /**
     * Add teacherReview
     *
     * @param \AppBundle\Entity\Review $teacherReview
     *
     * @return User
     */
    public function addTeacherReview(\AppBundle\Entity\Review $teacherReview)
    {
        $this->teacherReviews[] = $teacherReview;

        return $this;
    }

    /**
     * Remove teacherReview
     *
     * @param \AppBundle\Entity\Review $teacherReview
     */
    public function removeTeacherReview(\AppBundle\Entity\Review $teacherReview)
    {
        $this->teacherReviews->removeElement($teacherReview);
    }

    /**
     * Get teacherReviews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeacherReviews()
    {
        return $this->teacherReviews;
    }

    /**
     * Add studentReview
     *
     * @param \AppBundle\Entity\Review $studentReview
     *
     * @return User
     */
    public function addStudentReview(\AppBundle\Entity\Review $studentReview)
    {
        $this->studentReviews[] = $studentReview;

        return $this;
    }

    /**
     * Remove studentReview
     *
     * @param \AppBundle\Entity\Review $studentReview
     */
    public function removeStudentReview(\AppBundle\Entity\Review $studentReview)
    {
        $this->studentReviews->removeElement($studentReview);
    }

    /**
     * Get studentReviews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentReviews()
    {
        return $this->studentReviews;
    }

    /**
     * Set linkedInId
     *
     * @param integer $linkedInId
     *
     * @return User
     */
    public function setLinkedInId($linkedInId)
    {
        $this->linkedInId = $linkedInId;

        return $this;
    }

    /**
     * Get linkedInId
     *
     * @return integer
     */
    public function getLinkedInId()
    {
        return $this->linkedInId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return User
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add position
     *
     * @param \AppBundle\Entity\Position $position
     *
     * @return User
     */
    public function addPosition(\AppBundle\Entity\Position $position)
    {
        $this->positions[] = $position;

        return $this;
    }

    /**
     * Remove position
     *
     * @param \AppBundle\Entity\Position $position
     */
    public function removePosition(\AppBundle\Entity\Position $position)
    {
        $this->positions->removeElement($position);
    }

    /**
     * Get positions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPositions()
    {
        return $this->positions;
    }
}
