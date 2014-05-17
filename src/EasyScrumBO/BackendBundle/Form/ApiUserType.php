<?php
namespace EasyScrumBO\BackendBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApiUserType extends AdminUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('company', 'json_company', array('required'=>true));
    }

    public function getName()
    {
        return 'api_user';
    }

}