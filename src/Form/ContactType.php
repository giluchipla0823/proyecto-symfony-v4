<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                    'name'
                    , TextType::class
                    , array(
                        'label' => 'Nombres'
                        , 'constraints' => array(
                            new Assert\NotBlank()
                        )
                    )
                )
                ->add(
                    'email'
                    , EmailType::class
                    , array(
                        'label' => 'Email'
                        , 'constraints' => array(
                            new Assert\NotBlank()
                            , new Assert\Email()
                        )
                    )
                )
                ->add(
                    'subject'
                    , TextType::class
                    , array(
                        'label' => 'Asunto'
                        , 'constraints' => array(
                            new Assert\NotBlank()
                        )
                    )
                )
                ->add(
                    'message'
                    , TextareaType::class
                    , array(
                        'label' => 'Mensaje'
                        , 'constraints' => array(
                            new Assert\NotBlank()
                        )
                    )
                )
                ->add(
                    'submit'
                    , SubmitType::class
                    , array(
                        'label' => 'Enviar'
                        , 'attr' => array(
                            'class' => "btn btn-outline-primary"
                        )
                    )
                );


    }
}