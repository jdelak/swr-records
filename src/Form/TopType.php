<?php

namespace App\Form;

use App\Entity\Top;
use App\Entity\Racer;
use App\Entity\Race;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', ChoiceType::class, [
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10
                ]
            ])
            ->add('race', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Race',
                'class' => Race::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.id', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('racer', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Racer',
                'class' => Racer::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('ra')
                        ->orderBy('ra.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Top::class,
        ]);
    }
}
