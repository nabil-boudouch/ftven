<?php

namespace FTV\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text', array(
                'required'    => true
            ))
            ->add('leading','text', array(
                'required'    => false
            ))
            ->add('body','text', array(
                'required'    => true
            ))
            ->add('createdBy','text', array(
                'required'    => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FTV\ApiBundle\Entity\Article',
            'csrf_protection' => false,

        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'article';
    }
}
