<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Country;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'constraints' => array(new NotBlank()),
            ))
            ->add('username', TextType::class, array(
                'label' => 'Username',
                'constraints' => array(new NotBlank()),
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Password',
                'constraints' => array(new NotBlank()),
            ))
            ->add('confirm_password', PasswordType::class, array(
                'label' => 'Repeat Password',
                'constraints' => array(new NotBlank()),
            ))
            ->add('country', EntityType::class, [
                // looks for choices from this entity
                'label' => 'Country',
                'class' => Country::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.id', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
