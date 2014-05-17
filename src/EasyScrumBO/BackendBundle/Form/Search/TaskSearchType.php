<?php
namespace EasyScrumBO\BackendBundle\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntrySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => false))
            ->add('sprint', 'json_sprint', array('required' => false, 'empty_value'=>'Seleccione un sprint'));
    }

    public function getName()
    {
        return 'search_task';
    }

}