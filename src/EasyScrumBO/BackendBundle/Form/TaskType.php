<?php
namespace EasyScrumBO\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => true))
                ->add('description', 'textarea', array('required' => false))
                ->add('sprint', 'json_sprint', array('required' => true))
                ->add('priority', 'choice', array('required' => false, 'choices'=>array('P0'=>'P0','P2'=>'P2'),'empty_value' => 'Seleccione una prioridad'))
                ->add('hours', 'number', array('required' => true));
    }

    public function getName()
    {
        return 'entry';
    }

}