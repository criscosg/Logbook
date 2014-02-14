<?php

namespace Logbook\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'file', array('required' => true))
                ->add('horse', 'hidden', array('required' => true));
    }

    public function getName()
    {
        return 'image';
    }

}
