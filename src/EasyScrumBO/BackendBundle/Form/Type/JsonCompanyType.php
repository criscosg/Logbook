<?php
namespace EasyScrumBO\BackendBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use EasyScrumBO\BackendBundle\Model\Handler\RESTHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

class JsonCompanyType extends AbstractType
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
        $users = $this->handler->getList('companies', 'companies', $this->container->get('session')->get('access_token'));
        $final = array();
        $id = 1;
        foreach ($users as $owner) {
            foreach ($owner as $key => $value) {
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
        return 'json_company';
    }

}