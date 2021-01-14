<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Filter;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, [
                'choices' => ['Agriculteurs', 'Acheteurs'],
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'required' => false,
                'placeholder' => false
            ])
            ->add('category', ChoiceType::class, [
                'choices' => ['Blé', 'Avoine', 'Triticale', 'Orge', 'Maïs', 'Pois', 'Colza', 'Tournesol', 'Féverole'],
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'required' => false,
                'placeholder' => false
            ])
            ->add('farmSize', ChoiceType::class, [
                'choices' => ['< 100', '< 150', '< 200'],
                'expanded' => true,
                'multiple' => false,
                'label' => false,
                'required' => false,
                'placeholder' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filter::class
        ]);
    }
}
