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

            return $this->redirectToRoute('homepage');
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:Course:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
