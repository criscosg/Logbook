<?php
namespace Logbook\BackendBundle\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntrySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('required' => false))
            ->add('user', 'json_user', array('required' => false, 'empty_value'=>'Seleccione un dueño'));
    }

    public function getName()
    {
        return 'search_horse';
    }

}