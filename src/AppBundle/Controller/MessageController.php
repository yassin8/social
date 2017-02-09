<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 06/02/2017
 * Time: 21:48
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Message;
use AppBundle\Form\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MessageController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/message/new/{idProfile}", name="new_message")
     */
    public function newMessageAction(Request $request,$profile)
    {
        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user1= $this->getUser();
            $message->setStudent($user1);
            $message->setTeacher($profile);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        // replace this example code with whatever you need
//        return $this->render('AppBundle:search:message.html.twig', array(
//            'user' => $profile
//        ));
        return $this->render('AppBundle:message:newmessage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}