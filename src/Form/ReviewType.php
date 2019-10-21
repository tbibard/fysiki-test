<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', TextType::class, [
                'label'    => 'Alias',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label'    => 'E-mail',
                'required' => true,
            ])
            ->add('title', TextType::class, [
                'label'    => 'Title',
                'required' => true,
            ])
            ->add('comment', TextareaType::class, [
                'label'    => 'Comment',
                'required' => true,
                'attr' => array(
                    'rows' => 8,
                )
            ])
            ->add('photoFile', VichFileType::class, [
                'label'        => 'Photo',
                'required'     => false,
                'allow_delete' => false,
            ])
            ->add('note', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
