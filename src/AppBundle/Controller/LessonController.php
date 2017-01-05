<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Lesson;
use AppBundle\Entity\Skills;
use AppBundle\Entity\User;
use AppBundle\Entity\Course;
use AppBundle\Form\LessonType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LessonController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/lesson/new", name="new_lesson")
     */
    public function newLessonAction(Request $request)
    {
        $lesson = new Lesson();
        $user1= $this->getUser();
        //$skills = $usr->getTeacherSkills();

        //$user1 = new User();
        $lesson->setTeacher($user1);
        $user1->addTeacherLesson($lesson);

        $form = $this->createForm(LessonType::class,$lesson,array('label' => 1));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:Lesson:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/lesson/list", name="list_lesson")
     */
    public function ListLessonAction(Request $request)
    {
        $lessons = $this->getDoctrine()
            ->getRepository('AppBundle:Lesson')
            ->findAll();

        // createQueryBuilder() automatically selects FROM AppBundle:Product
        // and aliases it to "p"
        //$courses =$request->query->get('course');
        return $this->render('AppBundle:Lesson:index.html.twig', array(
            'lessons' => $lessons
        ));

    }
}