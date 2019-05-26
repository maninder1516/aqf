<?php

namespace AQF\AQFBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('serviceDate','date', array('format' => 'dd-MM-yyyy','label'=> 'Service Date:'))
                ->add('productName', 'text', array('label'=> 'Product Name:'))
                ->add('quantity', 'text', array('label'=> 'Quantity:'))
                ->add('destinationCountry', 'text', array('label'=> 'Destination Country:'))
                ->add('vendorName', 'text', array('label'=> 'Vendor Name:'))
                ->add('vendorEmail', 'text', array('label'=> 'Vendor Email:'));
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
