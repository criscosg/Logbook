<?php

namespace Logbook\BackendBundle\Controller;

use Logbook\BackendBundle\Controller\LogbookController;
use Logbook\BackendBundle\Form\HistoryType;

class HistoryController extends LogbookController
{
    public function listHistoriesAction($horse)
    {
        $session = $this->getRequest()->getSession();
        $horse = $this->get('rest.handler.model')->get('horses/'.$horse, 'horse', $session->get('access_token'));
        $histories = $this->get('history.handler.model')->getHistories($horse, $session->get('access_token'));

        return $this->render('BackendBundle:History:index.html.twig', array('histories' => $histories, 'horse' => $horse));
    }

    public function historyShowAction($horse, $id)
    {
        $session = $this->getRequest()->getSession();
        $history = $this->get('history.handler.model')->getHistory($horse, $id, $session->get('access_token'));
        $horse = $this->get('rest.handler.model')->get('horses/'.$horse, 'horse', $session->get('access_token'));

        return $this->render('BackendBundle:History:view.html.twig', array('history' => $history, 'horse' => $horse));
    }

    public function newHistoryAction($horse)
    {
        $session = $this->getRequest()->getSession();
        $form = $form = $this->createForm(new HistoryType());
        $horse = $this->get('rest.handler.model')->get('horses/'.$horse, 'horse', $session->get('access_token'));

        return $this->render('BackendBundle:History:create.html.twig', array('form' => $form->createView(), 'horse' => $horse));
    }

    public function editHistoryAction($horse, $id)
    {
        $session = $this->getRequest()->getSession();
        $horse = $this->get('rest.handler.model')->get('horses/'.$horse, 'horse', $session->get('access_token'));
        $history = $this->get('history.handler.model')->getHistory($horse, $id, $session->get('access_token'));
        $form = $form = $this->createForm(new HistoryType(), $history);

        return $this->render('BackendBundle:History:create.html.twig', array('form' => $form->createView(),'edition' => true, 'id' => $id, 'horse' => $horse));
    }

    public function createHistoryAction($horse)
    {
        $session = $this->getRequest()->getSession();
        $params = $this->getRequest()->request->get('history');
        $horse = $this->get('rest.handler.model')->get('horses/'.$horse, 'horse', $session->get('access_token'));
        $history = $this->get('history.handler.model')->postHistory($horse, array('history' => $params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('histories_list', array('horse' => $horse['id'])));
    }

    public function putHistoryAction($horse, $id)
    {
        $session = $this->getRequest()->getSession();
        $params = $this->getRequest()->request->get('history');
        $horse = $this->get('rest.handler.model')->get('horses/'.$horse, 'horse', $session->get('access_token'));
        $history = $this->get('history.handler.model')->putHistory($horse, $id, array('history' => $params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('histories_list', array('horse' => $horse['id'])));
    }

    public function deleteHistoryAction($horse, $id)
    {
        $session = $this->getRequest()->getSession();
        $history = $this->get('history.handler.model')->deleteHistory($horse, $id, $session->get('access_token'));

        return $this->redirect($this->generateUrl('histories_list', array('horse' => $horse)));
    }
}