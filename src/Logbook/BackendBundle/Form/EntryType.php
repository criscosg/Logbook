<?php
namespace Logbook\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HorseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('required' => true))
                ->add('text', 'textarea', array('required' => false))
                ->add('owner', 'json_user', array('required' => true));
    }

    public function getName()
    {
        return 'horse';
    }

}