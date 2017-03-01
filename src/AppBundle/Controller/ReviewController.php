<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use AppBundle\Entity\User;
use AppBundle\Form\ReviewType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReviewController
 */
class ReviewController extends Controller
{
    /**
     * @param Request $request
     * @param int $userId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/review/new/{userId}", name="new_review")
     */
    public function newCourseAction(Request $request, $userId)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user= $this->getUser();
            $review->setStudent($user);
            $review->setTeacher($em->getReference(User::class, $userId));
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('AppBundle:Review:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
