<?php
namespace EasyScrumBO\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SprintType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => true))
            ->add('company', 'json_company', array('required'=>true))
            ->add('description', 'textarea', array('required' => false))
            ->add('hoursAvailable', 'number', array('required'=>true))
            ->add('hoursPlanified', 'number', array('required'=>true));
    }

    public function getName()
    {
        return 'sprint';
    }

}