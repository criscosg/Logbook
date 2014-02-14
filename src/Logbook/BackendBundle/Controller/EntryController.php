<?php

namespace Logbook\BackendBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Logbook\BackendBundle\Controller\LogbookController;
use Logbook\BackendBundle\Form\EntryType;
use Logbook\BackendBundle\Form\Search\EntrySearchType;
use Logbook\BackendBundle\Util\StringHelper;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class EntryController extends LogbookController
{
    public function listEntriesAction()
    {
        $session = $this->getRequest()->getSession();
        $form = $this->createForm(new EntrySearchType(), $this->getRequest()->query->get('search_entry'));
        $form->handleRequest($this->getRequest());
        $params = array('access_token'=>$session->get('access_token'), 'search_entry'=> $this->getRequest()->query->get('search_entry'));
        $entries = $this->get('rest.handler.model')->getList('entries', 'entries', $params);

        return $this->render('BackendBundle:Entry:index.html.twig', array('entries' => $entries, 'form'=>$form->createView()));
    }

    public function entryShowAction($id)
    {
        $session = $this->getRequest()->getSession();
        $entry = $this->get('rest.handler.model')->get('entries/'.$id, 'entry', $session->get('access_token'));
        $images = $this->get('image.handler.model')->getImagesThumb(array('entry' => $id,'access_token' => $session->get('access_token')));
        $history = $this->get('history.handler.model')->getHistories($entry, $session->get('access_token'));

        return $this->render('BackendBundle:Entry:view.html.twig', array('entry' => $entry, 'images' => $images, 'history' => $history));
    }

    public function newEntryAction()
    {
        $form = $this->createForm(new EntryType());

        return $this->render('BackendBundle:Entry:create.html.twig', array('form' => $form->createView()));
    }

    public function editEntryAction($id)
    {
        $session = $this->getRequest()->getSession();
        $entry = $this->get('rest.handler.model')->get('entries/'.$id, 'entry', $session->get('access_token'));
        $array = new ArrayCollection($entry);
        if ($array->containsKey('birthdate')) {
            $entry['birthdate'] = new \DateTime($entry['birthdate']);
        }
        $form = $this->createForm(new EntryType(), $entry);

        return $this->render('BackendBundle:Entry:create.html.twig', array('form' => $form->createView(),'edition' => true, 'id' => $id));
    }

    public function createEntryAction()
    {
        $session = $this->getRequest()->getSession();
        $params = $this->getRequest()->request->get('entry');
        $entry = $this->get('rest.handler.model')->post("entries", array('entry'=>$params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('entries_list'));
    }

    public function putEntryAction($id)
    {
        $params = $this->getRequest()->request->get('entry');
        $session = $this->getRequest()->getSession();
        $entry = $this->get('rest.handler.model')->put("entries/".$id, array('entry'=>$params), $session->get('access_token'));

        return $this->redirect($this->generateUrl('entries_list'));
    }

    public function deleteEntryAction($id)
    {
        $session = $this->getRequest()->getSession();
        $entry = $this->get('rest.handler.model')->delete("entries/".$id, $session->get('access_token'));

        return $this->redirect($this->generateUrl('entries_list'));
    }
}