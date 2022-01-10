<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;

//Este form sirve para agregarle campos al registro del user
//No olvidarse de registrarlo en el services y en config.yml en caso de querer hacer uno nuevo
class RegistrationFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //En este choice definimos los roles
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ]
            ])
            ->add('cuit')
            ->add('razonSocial')
            ;
            

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count((is_countable($rolesArray)?$rolesArray:[]));
                    
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
        ));
    }
    

    //Esto hereda del form que esta en la carpeta del bundle
    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }
}