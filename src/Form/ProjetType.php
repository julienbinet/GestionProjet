<?php

namespace App\Form;

use App\Entity\Projet;
use App\Form\Type\DateTimePickerType;
use App\Form\TacheListType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nom'])
            ->add('description')
            ->add('date_debut', DateTimePickerType::class, [
                'label' => 'Date de début',
//                'attr' => ['class' => 'col-md-6'],
            ])
            ->add('date_fin', DateTimePickerType::class, [
                'label' => 'Date de fin',
            ])
            ->add('taches', CollectionType::class, array(
                // each entry in the array will be an "email" field
                'entry_type' => TacheListType::class,
                // these options are passed to each "email" type
                'entry_options' => array(
                    'attr' => array('class' => 'email-box'),
                ),
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
