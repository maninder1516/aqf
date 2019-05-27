<?php

namespace AQF\AQFBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MissionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('serviceDate', DateType::class, ['format' => 'dd-MM-yyyy','label'=> 'Service Date:'])
                ->add('productName', TextType::class, ['label'=> 'Product Name:'])
                ->add('quantity', TextType::class, ['label'=> 'Quantity:'])
                ->add('destinationCountry', TextType::class, ['label'=> 'Destination Country:'])
                ->add('vendorName', TextType::class, ['label'=> 'Vendor Name:'])
                ->add('vendorEmail', EmailType::class, ['label'=> 'Vendor Email:']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AQF\AQFBundle\Entity\Mission'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'aqf_aqfbundle_mission';
    }

    public function getName()
    {
        return 'mission';
    }

}
