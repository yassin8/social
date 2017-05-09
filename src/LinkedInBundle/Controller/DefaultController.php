<?php

namespace LinkedInBundle\Controller;

use Happyr\LinkedIn\LinkedIn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    const LINKEDIN_PROFILE_LIST = array(
        'id',
        'first-name',
        'last-name',
        'headline',
        'location',
        'industry',
        'summary',
        'specialties',
        'positions',
        'picture-url'
    );

    public function indexAction()
    {
        return $this->render('LinkedInBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/linkedin/auto-response", name="linked_in_register")
     */
    public function registerAction(Request $request)
    {
        $linkedIn = $this->getLinkedInService();

        if ($linkedIn->isAuthenticated()) {
            $userManager = $this->get('user.manager');
            $userData = $linkedIn->get(sprintf('v1/people/~:(%s)', implode(',', self::LINKEDIN_PROFILE_LIST)));
            $user = $userManager->findUserByLinkedInId($userData['id']);
            if (!$user) {
                $user = $userManager->createUserFormLinkedInData($userData);
            }

            $token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());
            $this->get("security.token_storage")->setToken($token);
            return $this->redirectToRoute('homepage');
        } elseif ($linkedIn->hasError()) {
            echo "User canceled the login.";
            exit();
        }

        return $this->redirect($linkedIn->getLoginUrl());
    }

    /**
     * @return LinkedIn
     */
    public function getLinkedInService() {
        return $this->get('happyr.linkedin');
    }
}
