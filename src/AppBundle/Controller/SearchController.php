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
            ->getForm()
            ->add('Go', SubmitType::class);
        $profilesSearch  = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $search =  $form->getData()['search'];
            $profilesSearch = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->findByName($search);
            /*$em->persist($lsUsers);
            $em->flush();*/

            return $this->render('AppBundle:Search:profile.html.twig', [
                'form' => $form->createView(),
                'profilesSearch' => $profilesSearch
            ]);
        }

        return $this->render('AppBundle:Search:profile.html.twig', [
            'form' => $form->createView(),
            'profilesSearch' => $profilesSearch
        ]);
        /*

        $form = $this->createForm(UsertType::class, $lsUsers);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lsUsers);
            $em->flush();

            return $this->redirectToRoute('list_users');
        }
        return $this->render('AppBundle:Search:profile.html.twig', array(

        ));
        */
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

        // createQueryBuilder() automatically selects FROM AppBundle:Product
        // and aliases it to "p"
        //$courses =$request->query->get('course');
        return $this->render('AppBundle:search:lsprofiles.html.twig', array(
            'users' => $courses
        ));
    }
}