<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 06/02/2017
 * Time: 21:48
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Message;
use AppBundle\Entity\User;
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
    public function newMessageAction(Request $request,$idProfile)
    {
        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user1= $this->getUser();
            $message->setStudent($user1);
            $message->setTeacher($em->getReference(User::class, $idProfile));

            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('list_message');
        }

        return $this->render('AppBundle:message:newmessage.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/message/list", name="list_message")
     */
    public function ListMessageAction(Request $request)
    {
        $user1= $this->getUser();
        $messages = $this->getDoctrine()
            ->getRepository('AppBundle:Message')
            ->findById($user1);

        // createQueryBuilder() automatically selects FROM AppBundle:Product
        // and aliases it to "p"
        //$courses =$request->query->get('course');
        return $this->render('AppBundle:Message:listmessage.html.twig', array(
            'messages' => $messages
        ));

    }
}