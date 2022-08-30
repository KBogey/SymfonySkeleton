<?php

namespace App\Form;

use App\Entity\Listing;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'annonce',
                'attr' => [
                    'class' => 'px-2'
                ]
            ])
            ->add('description', TextType::class, ['label' => 'Description de la machine'])
            ->add('mileage', IntegerType::class, ['label' => 'Kilométrage'])
            ->add('price', NumberType::class, ['label' => "Prix de l'engin"])
            ->add('producedYear', IntegerType::class, ['label' => 'Année de production de la bête'])
            ->add('model', EntityType::class, [
                'label' => 'Modèle',
                'class' => Model::class,
                'choice_label' => function (Model $model) {
                    return $model->getName();
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter l\'annonce',
                'attr' => [
                    'class' => 'btn btn-primary px-2 mt-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
