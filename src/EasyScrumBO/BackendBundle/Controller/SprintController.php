<?php

namespace EasyScrumBO\BackendBundle\Controller;

use EasyScrumBO\BackendBundle\Controller\EasyScrumController;
use EasyScrumBO\BackendBundle\Form\SprintType;
use EasyScrumBO\BackendBundle\Form\Search\SprintSearchType;

class SprintController extends EasyScrumController
{
    public function listSprintsAction()
    {
        $form = $this->createForm(new SprintSearchType(), $this->getRequest()->query->get('search_sprint'));
        $form->handleRequest($this->getRequest());
        $session = $this->getRequest()->getSession();
        $params = array('access_token' => $session->get('access_token'), 'search_sprint' => $this->getRequest()->query->get('search_sprint'));
        $sprints = $this->get('rest.handler.model')->getList('sprints', 'sprints', $params);

        return $this->render('BackendBundle:Sprint:index.html.twig', array('sprints' => $sprints, 'form'=>$form->createView()));
    }

    public function sprintShowAction($id)
    {
        $session = $this->getRequest()->getSession();
        $sprint = $this->get('rest.handler.model')->get('sprints/'.$id, 'sprint', $session->get('access_token'));

        return $this->render('BackendBundle:Sprint:view.html.twig', array('sprint' => $sprint));
    }

    public function newSprintAction()
    {
        $form = $this->createForm(new SprintType());

        return $this->render('BackendBundle:Sprint:create.html.twig', array('form' => $form->createView()));
    }

    public function editSprintAction($id)
    {
        $session = $this->getRequest()->getSession();
        $sprint = $this->get('rest.handler.model')->get('sprints/'.$id, 'sprint', $session->get('access_token'));
        $form = $this->createForm(new SprintType(), $sprint);

        return $this->render('BackendBundle:Sprint:create.html.twig', array('form' => $form->createView(),'edition' => true, 'id' => $id));
    }

    public function createSprintAction()
    {
        $params = $this->getRequest()->request->get('sprint');
        $session = $this->getRequest()->getSession();
        $sprint = $this->get('rest.handler.model')->post("sprints", array('sprint' => $params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('sprints_list'));
    }

    public function putSprintAction($id)
    {
        $params = $this->getRequest()->request->get('sprint');
        $session = $this->getRequest()->getSession();
        $sprint = $this->get('rest.handler.model')->put("sprints/".$id, array('sprint' => $params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('sprints_list'));
    }

    public function deleteSprintAction($id)
    {
        $session = $this->getRequest()->getSession();
        $sprint = $this->get('rest.handler.model')->delete("sprints/".$id, $session->get('access_token'));

        return $this->redirect($this->generateUrl('sprints_list'));
    }
}