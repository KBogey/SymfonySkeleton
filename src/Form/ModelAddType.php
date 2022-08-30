<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom du modèle'])
            ->add('description', TextType::class, ['label' => 'Description du modèle'])
            ->add('brand', EntityType::class, [
                'label' => 'Marque du modèle',
                'class' => Brand::class,
                'choice_label' => function (Brand $brand) {
                    return $brand->getName();
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter le modèle',
                'attr' => ['class' => 'btn btn-primary px-2 mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
        ]);
    }
}
