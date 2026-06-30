<?php

namespace App\Form;

use App\Entity\Pret;
use App\Entity\Materiel;
use App\Entity\Adherent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PretType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_pret', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('date_retour_prevue', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('date_retour_effective', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('materiel', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => 'nom',
            ])
            ->add('adherent', EntityType::class, [
                'class' => Adherent::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pret::class,
        ]);
    }
}