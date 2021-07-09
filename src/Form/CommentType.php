<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class, [
                'attr' => [
                    'placeholder' => "votre nom", 'class' => 'form-control'
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => "Email", 'class' => 'form-control'
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'placeholder' => "commnenter", 'class' => 'form-control'
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
