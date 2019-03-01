<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('prenom', TextType::class)   
            ->add('nom', TextType::class)
            ->add('email', RepeatedType::class, array(
                'type' => EmailType::class,
                'first_options' => array('label' => 'Email'),
                'second_options' => array('label' => 'Confirmation de votre email'),
            ))
            ->add('submit', SubmitType::class, ['label'=>'Modifier vos informations', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }
}