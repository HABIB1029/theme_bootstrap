<?php

namespace App\Form;

use App\Entity\Announce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('slug')

            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => "Titre de l'annonce", 'class' => 'form-control'
                ]
            ])
            ->add('introduction', TextType::class, [
                'attr' => [
                    'placeholder' => "Introduction", 'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => "saisir une brève description", 'class' => 'form-control'
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'placeholder' => "veuillez entrer le prix svp", 'class' => 'form-control'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'placeholder' => "Adresse", 'class' => 'form-control'
                ]
            ])
            ->add('imageCover', FileType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "saisir l'URL", 'class' => 'form-control'
                ]
            ])
            ->add('rooms', NumberType::class, [
                'attr' => [
                    'placeholder' => "Nombre de chambre", 'class' => 'form-control'
                ]
            ])
            ->add('isAvailable', CheckboxType::class, [
                'label'    => 'disponible',
                'required' => false,
            ])
            
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
        ]);
    }
}
