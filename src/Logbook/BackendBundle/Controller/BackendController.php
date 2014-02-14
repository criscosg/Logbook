<?php

namespace Logbook\BackendBundle\Controller;

use Logbook\BackendBundle\Controller\LogbookController;
use Guzzle\Http\Message\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller
{
    public function exampleAction()
    {
        $request=$this->getRequest();
        $session = $request->getSession();

        return $this->render('BackendBundle:Backend:example.html.twig');
    }

    public function loginAction()
    {
        return $this->redirect($this->container->getParameter('Logbook.rest.uri').'oauth/v2/auth?client_id='.$this->container->getParameter('Logbook.rest.oauth.id').
                                        '&redirect_uri='.$this->generateUrl('oauth_procesator', array(), true).'&response_type=token');
    }

    public function OauthProcesatorAction()
    {
        $request=$this->getRequest();
        if ($request->query->get('access_token')) {
            $session = $request->getSession();
            $session->set('access_token', $request->query->get('access_token'));
            $session->set('refresh_token', $request->query->get('refresh_token'));
            $now =new \DateTime('now');
            $interval=new \DateInterval('PT'.$request->query->get('expires_in').'S');
            $now->add($interval);
            $session->set('expires', $now->getTimestamp());

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('BackendBundle:Backend:oauth-procesator.html.twig');
    }
}
