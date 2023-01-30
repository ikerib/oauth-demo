<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/connect', name: 'oauth_connect')]
    public function connect(ClientRegistry $clientRegistry)
    {
        return $clientRegistry->getClient('generic')->redirect(['email']);
    }


    #[Route(path: '/connect/check', name: 'oauth_check')]
    public function check(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)


//        /** @var OAuth2Client $client */
//        $client = $clientRegistry->getClient('generic');
//
//        try {
//            // the exact class depends on which provider you're using
////            $user = $client->fetchUser();
//            $accessToken = $client->getAccessToken();
//            $user = $client->fetchUserFromToken($accessToken);
//            // do something with all this new power!
//            // e.g. $name = $user->getFirstName();
//
//            // ...
//        } catch (IdentityProviderException $e) {
//            // something went wrong!
//            // probably you should return the reason to the user
//            var_dump($e->getMessage()); die;
//        }

    }
}
