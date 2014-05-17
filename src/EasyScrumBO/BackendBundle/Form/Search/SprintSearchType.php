<?php
namespace EasyScrumBO\BackendBundle\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SprintSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => false))
            ->add('company', 'json_company', array('required'=>false, 'empty_value'=>'Seleccione un usuario'));
    }

    public function getName()
    {
        return 'search_sprint';
    }

}