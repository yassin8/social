<?php

namespace UserBundle\Controller;

use AppBundle\Entity\Skills;
use AppBundle\Form\RegistrationStep2Type;
use AppBundle\Form\RegistrationStep3Type;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/register", name="new_member")
     *
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $skill = new Skills();
        $skill->setLevel(5);
        $skill->setTeacher($user);
        $user->addTeacherSkill($skill);

        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('register_step_2', array('userId' => $user->getId()));
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param string $userId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/register/step/2/{userId}", name="register_step_2")
     */
    public function registerStep2Action(Request $request, $userId)
    {
        $user = $this->getUser();

        $form = $this->createForm(RegistrationStep2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('register_step_3', array('userId' => $user->getId()));
        }

        return $this->render('AppBundle:User:Registration/register_content_step_2.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @param Request $request
     * @param string $userId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/register/step/3/{userId}", name="register_step_3")
     */
    public function registerStep3Action(Request $request, $userId)
    {
        $user = $this->getUser();

        $form = $this->createForm(RegistrationStep3Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('fos_user_registration_confirmed');
        }

        return $this->render('AppBundle:User:Registration/register_content_step_3.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
