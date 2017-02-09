<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,array(
            "label" => "Nom : ",
            "attr" => array('class' => ''),
            ))
            ->add('content', TextareaType::class,array(
                'attr' => array('class' => 'materialize-textarea'),
            ))
            ->add('releaseDate',DateType::class, array(
                'label_attr' => array( 'for'=>'releaseDate'),
                'widget' => 'single_text',
                'html5' => false,

            ))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'name',
                'attr' => array('class' => 'browser-default'),
            ))
            ->add('tags', EntityType::class, array(
                'class' => 'AppBundle:Tag',
                'choice_label' => 'name',
                'attr' => array( 'type' => 'checkbox'),
                'expanded' => true,
                'multiple' => true,
            ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}
