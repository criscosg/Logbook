<?php

namespace EasyScrumBO\BackendBundle\Controller;

use EasyScrumBO\BackendBundle\Controller\EasyScrumController;
use EasyScrumBO\BackendBundle\Form\ApiUserType;

class ApiUserController extends EasyScrumController
{
    public function listApiUsersAction()
    {
        $session = $this->getRequest()->getSession();
        $apiUsers = $this->get('rest.handler.model')->getList('api/users', 'api_users', $session->get('access_token'));

        return $this->render('BackendBundle:ApiUser:index.html.twig', array('api_users' => $apiUsers));
    }

    public function apiUserShowAction($id)
    {
        $session = $this->getRequest()->getSession();
        $apiUser = $this->get('rest.handler.model')->get('apis/'.$id.'/user', 'api_user', $session->get('access_token'));

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
        $apiUser = $this->get('rest.handler.model')->get('apis/'.$id.'/user', 'api_user', $session->get('access_token'));
        $form = $form = $this->createForm(new ApiUserType(), $apiUser);

        return $this->render('BackendBundle:ApiUser:create.html.twig', array('form' => $form->createView(),'edition' => true, 'id' => $id));
    }

    public function createApiUserAction()
    {
        $params = $this->getRequest()->request->get('api_user');
        $session = $this->getRequest()->getSession();
        $apiUser = $this->get('rest.handler.model')->post("apis/users", array('api_user' => $params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('api_users_list'));
    }

    public function putApiUserAction($id)
    {
        $params = $this->getRequest()->request->get('api_user');
        $session = $this->getRequest()->getSession();
        if ($params['password'] == "") {
            $apiUser = $this->get('rest.handler.model')->patch('apis/'.$id.'/user', array('api_user' => $params), $session->get('access_token'));
        } else {
            $apiUser = $this->get('rest.handler.model')->put('apis/'.$id.'/user', array('api_user' => $params), $session->get('access_token'));
        }

        return $this->redirect($this->generateUrl('api_users_list'));
    }

    public function deleteApiUserAction($id)
    {
        $session = $this->getRequest()->getSession();
        $apiUser = $this->get('rest.handler.model')->delete('api/'.$id.'/user'.$id, $session->get('access_token'));

        return $this->redirect($this->generateUrl('api_users_list'));
    }
}