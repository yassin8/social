<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 06/02/2017
 * Time: 21:48
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Discussion;
use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Form\DiscussionType;
use AppBundle\Form\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MessageController extends Controller
{
    /**
     * @param Request $request
     * @param int     $idProfile
     *
     * @return Response
     * @Route("/discussion/new/{idProfile}", name="new_discussion")
     */
    public function newDiscussionAction(Request $request,$idProfile)
    {
        $discussion = new Discussion();
        $message = new Message();
        $discussion->addMessage($message);

        $form = $this->createForm(DiscussionType::class, $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user= $this->getUser();
            $message = $discussion->getMessages()[0];
            $message->setUser($user);
            $message->setDiscussion($discussion);
            $discussion->setStudent($user);
            $discussion->setTeacher($em->getReference(User::class, $idProfile));

            $em->persist($message);
            $em->persist($discussion);
            $em->flush();

            return $this->redirectToRoute('discussion_messages', array('id' => $discussion->getId()));
        }

        return $this->render('AppBundle:message:newmessage.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/discussion/{id}", name="discussion_messages")
     */
    public function showDiscussionAction(Request $request, $id)
    {
        $user = $this->getUser();

        $discussion = $this->getDoctrine()
            ->getRepository('AppBundle:Discussion')
            ->find($id);
        $discussionUser = $discussion->getStudent()->getId() ==  $this->getUser()->getId()
            ? $discussion->getTeacher()
            : $discussion->getStudent();

        $discussionList1 = $this->getDoctrine()
            ->getRepository('AppBundle:Discussion')
            ->findByStudent($user);

        $discussionList2 = $this->getDoctrine()
            ->getRepository('AppBundle:Discussion')
            ->findByTeacher($user);

        $discussionList = $discussionList1 +  $discussionList2;

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        return $this->render('AppBundle:Message:discussion.html.twig', array(
            'discussion' => $discussion,
            'form' => $form->createView(),
            'discussion_list' => $discussionList,
            'discussion_user' => $discussionUser,
            'current_user' => $user,
        ));
    }

    /**
     * @param Request $request
     * @param int     $discussionId
     *
     * @return Response
     * @Route("/message/new/{discussionId}", name="new_message")
     */
    public function newMessageAction(Request $request,$discussionId)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $message->setUser($user);
            $message->setDiscussion($em->getReference(User::class, $discussionId));

            $em->persist($message);
            $em->flush();
        }

        return $this->redirectToRoute('discussion_messages', array('id' => $discussionId));
    }
}