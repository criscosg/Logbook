<?php

namespace Logbook\BackendBundle\Controller;

use Logbook\BackendBundle\Controller\LogbookController;
use Logbook\BackendBundle\Form\ApiUserType;

class ApiUserController extends LogbookController
{
    public function listVeterinariesAction()
    {
        $session = $this->getRequest()->getSession();
        $apiUsers = $this->get('rest.handler.model')->getList('api/users', 'api_users', $session->get('access_token'));

        return $this->render('BackendBundle:ApiUser:index.html.twig', array('api_users' => $apiUsers));
    }

    public function api_userShowAction($id)
    {
        $session = $this->getRequest()->getSession();
        $apiUser = $this->get('rest.handler.model')->get('api/users/'.$id, 'api_user', $session->get('access_token'));

        return $this->render('BackendBundle:ApiUser:view.html.twig', array('api_user' => $apiUser));
    }

    public function newApiUserAction()
    {
        $form = $form = $this->createForm(new ApiUserType());

        return $this->render('BackendBundle:ApiUser:create.html.twig', array('form' => $form->createView()));
    }

    public function editApiUserAction($id)
    {
        $session = $this->getRequest()->getSession();
        $apiUser = $this->get('rest.handler.model')->get('api/users/'.$id, 'api_user', $session->get('access_token'));
        $form = $form = $this->createForm(new ApiUserType(), $apiUser);

        return $this->render('BackendBundle:ApiUser:create.html.twig', array('form' => $form->createView(),'edition' => true, 'id' => $id));
    }

    public function createApiUserAction()
    {
        $params = $this->getRequest()->request->get('api_user');
        $session = $this->getRequest()->getSession();
        $apiUser = $this->get('rest.handler.model')->post("api/users", array('api_user' => $params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('api_users_list'));
    }

    public function putApiUserAction($id)
    {
        $params = $this->getRequest()->request->get('api_user');
        $session = $this->getRequest()->getSession();
        if ($params['password'] == "") {
            $apiUser = $this->get('rest.handler.model')->patch("api/users/".$id, array('api_user' => $params), $session->get('access_token'));
        } else {
            $apiUser = $this->get('rest.handler.model')->put("api/users/".$id, array('api_user' => $params), $session->get('access_token'));
        }

        return $this->redirect($this->generateUrl('api_users_list'));
    }

    public function deleteApiUserAction($id)
    {
        $session = $this->getRequest()->getSession();
        $apiUser = $this->get('rest.handler.model')->delete("api/users/".$id, $session->get('access_token'));

        return $this->redirect($this->generateUrl('api_users_list'));
    }
}