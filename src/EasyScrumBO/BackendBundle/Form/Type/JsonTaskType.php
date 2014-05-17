<?php
namespace EasyScrumBO\BackendBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;

use EasyScrumBO\BackendBundle\Model\Handler\RESTHandler;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

class JsonTaskType extends AbstractType
{
    private $handler;
    private $container;

    public function __construct(RESTHandler $handler, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->container = $container;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'choices' => $this->getChoices(),
        ));
    }

    private function getChoices()
    {
        $entries = $this->handler->getList('tasks', 'tasks', $this->container->get('session')->get('access_token'));
        $final = array();
        $id = 1;
        foreach ($entries as $entry) {
            foreach ($entry as $key => $value) {
                if ($key == 'id') {
                    $id = $value;
                }
                if ($key == 'name') {
                    $final[$id] = $value;
                }
            }
        }

        return $final;
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'json_task';
    }

}