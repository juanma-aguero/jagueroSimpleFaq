<?php

namespace Jaguero\SimpleFaqBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('title')
            ->add('answer', 'ckeditor')
            ->add('enabled')
            ->add('position')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jaguero\SimpleFaqBundle\Entity\Question',
            'translation_domain' => 'Question',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'question';
    }
}
