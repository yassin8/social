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
     * @param $idTeacher
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/lesson/new/{idTeacher}", name="new_lesson")
     */
    public function newLessonAction(Request $request, $idTeacher)
    {
        $lesson = new Lesson();
        $user1= $this->getUser();
        $lesson->setStudent($user1);

        $form = $this->createForm(LessonType::class,$lesson,array('label' => 1));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $teacher = $em->getRepository('AppBundle:User')->find($idTeacher);
            $lesson->setTeacher($teacher);
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
        
        return $this->render('AppBundle:Lesson:index.html.twig', array(
            'lessons' => $lessons
        ));

    }
}