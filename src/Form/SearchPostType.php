<?php

namespace App\Form;

use App\Entity\Category;
use App\Faker\PostProvider;
use App\Repository\AuthorRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchPostType extends AbstractType
{
    public function __construct(
        private PostRepository $postRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author' , ChoiceType::class, [
                'choices' =>
                    array_combine($this->postRepository->getAllFromColumn('author' ), $this->postRepository->getAllFromColumn('author')),


            ])
             ->add('language' , ChoiceType::class, [
                'choices' =>
                    array_combine($this->postRepository->getAllFromColumn('language' ), $this->postRepository->getAllFromColumn('language')),
             ])
            ->add('Categorie' , EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
             ])
             ->add('recherche' , SubmitType::class)

        ;
    }
}