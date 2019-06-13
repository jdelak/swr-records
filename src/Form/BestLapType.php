<?php

namespace App\Form;

use App\Entity\BestLap;
use App\Entity\Racer;
use App\Entity\Race;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class BestLapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('time', TextType::class, array(
                'label' => 'Time : min:sec:milisec',
                    'attr' => array(
                        'placeholder' => '00:00:00',
                    )
            ))
            ->add('crash', TextType::class, array(
                'label' => 'Put 0 if no crash',
            ))
            ->add('video', TextType::class, array(
                'label' => 'Video url (in this format : https://www.youtube.com/embed/wCP04PPgSj0)',
                'constraints' => array(new NotBlank()),
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BestLap::class,
        ]);
    }
}
