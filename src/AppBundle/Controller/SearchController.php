<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 07/01/2017
 * Time: 21:15
 */

namespace AppBundle\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Course;
use AppBundle\Form\CourseType;
use AppBundle\Form\LessonType;
use AppBundle\Form\UsertType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profile/search", name="search_profile")
     */
    public function ProfileAction(Request $request)
    {
        $lsUsers = Array();
        $form = $this->createFormBuilder($lsUsers)
            ->add('search')
            ->getForm();

        $profilesSearch  = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $search =  $form->getData()['search'];
            $profilesSearch = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->findByName($search);

            return $this->render('AppBundle:Search:lsprofiles.html.twig', [
                'form' => $form->createView(),
                'profilesSearch' => $profilesSearch
            ]);
        }

        return $this->render('AppBundle:Search:lsprofiles.html.twig', [
            'form' => $form->createView(),
            'profilesSearch' => $profilesSearch
        ]);

    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profile/List", name="get_list_profile")
     */
    public function ListUsersAction(Request $request)
    {
        $courses = $this->getDoctrine()
            ->getRepository('AppBundle:users')
            ->findAll();

        return $this->render('AppBundle:search:lsprofiles.html.twig', array(
            'users' => $courses
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profile/search/{idProfile}", name="get_id_profile")
     */
    public function IndexUserAction(Request $request, $idProfile)
    {
        $profile = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($idProfile);

        return $this->render('AppBundle:search:profile.html.twig', array(
            'user' => $profile
        ));
    }
}