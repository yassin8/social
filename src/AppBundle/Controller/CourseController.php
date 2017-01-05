<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Form\CourseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/course/new", name="new_course")
     */
    public function newCourseAction(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();

            return $this->redirectToRoute('list_course');
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:Course:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/course/get", name="list_course")
     */
    public function ListCourseAction(Request $request)
    {
        $courses = $this->getDoctrine()
            ->getRepository('AppBundle:Course')
            ->findAll();

        // createQueryBuilder() automatically selects FROM AppBundle:Product
        // and aliases it to "p"
        //$courses =$request->query->get('course');
        return $this->render('AppBundle:Course:index.html.twig', array(
            'courses' => $courses
        ));

    }
}
