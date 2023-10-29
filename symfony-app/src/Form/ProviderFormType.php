<?php

namespace App\Form;

use App\Entity\Provider;
use App\Entity\ProviderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProviderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Correo',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Teléfono',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Teléfono',
                ],
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Activo',
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
                'label_attr' => [
                    'class' => 'form-check-label',
                ],
            ])
            ->add('providerType', EntityType::class, [                
                'label' => 'Tipo',
                'attr' => [
                    'class' => 'form-select',
                    'aria-label' => 'State',
                ],
                'class' => ProviderType::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un tipo de proveedor',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Provider::class,
            'csrf_token_id'   => 'form_intention',
        ]);
    }
}
