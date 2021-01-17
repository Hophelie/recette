<?php

namespace App\Form;

use App\Entity\AlimentFiltre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('prixMax',IntegerType::class,[
                'label'=>false,
                'attr' =>[
                    'placeholder'=> 'Prix max']
            ] )
            ->add('glucidesMax',IntegerType::class,[
                'label'=>false,
                'attr' =>[
                    'placeholder'=> 'Glucides max']
            ] )
            ->add('submit',SubmitType::class,[
                'label'=>'Filtrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AlimentFiltre::class,
        ]);
    }
}
