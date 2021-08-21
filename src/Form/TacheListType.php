<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Tache;
use App\Entity\User;
use App\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TacheListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('jour', DateTimePickerType::class, [
                'label' => 'Jour',
            ])
            ->add('duree', null, [
                "help" => "heures:minutes"
            ])
            /*->add('projet', EntityType::class, [
                    'class' => Projet::class,
                    'choice_label' => 'name']
            )
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])*/;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
