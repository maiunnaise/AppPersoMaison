<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Tag;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('dueAt', DateTimeType::class,[
                'widget'=>'single_text'
            ])
            ->add('isFinished')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'query_builder'=> function (EntityRepository $er){
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'choice_label'=>'name',
                'label'=>'Utilisateur',
                'attr'=>array(
                    'title'=>'Utilisateur'
                )
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'query_builder'=> function (EntityRepository $er){
                    return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'choice_label'=>'name',
                'label'=>'Catégorie',
                'attr'=>array(
                    'title'=>'Catégorie'
                )
            ])
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'query_builder'=> function (EntityRepository $er){
                    return $er->createQueryBuilder('c')->orderBy('c.id', 'ASC');
                },
                'choice_label'=>'id',
                'label'=>'Session',
                'attr'=>array(
                    'title'=>'Session'
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
