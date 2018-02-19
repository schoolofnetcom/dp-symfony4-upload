<?php

namespace App\Form;

use App\Entity\Livro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('ebook', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('capa', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('salvar', SubmitType::class, [
                'attr' => [
                    'label' => 'Enviar',
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => Livro::class,
        ]);
    }
}
