<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Services\ImageHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog')]
    public function blog(PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $posts = $postRepository->findAll();

        return $this->render('base.html.twig', [
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }

    #[Route('/post/add', name: 'app_add_post')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $form  =  $this->createForm(PostType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $path = $this->getParameter('kernel.project_dir') . '/public/images';
            $post = $form->getData();
            $image = $post->getImage();

            $image->setPath($path);

            $manager->persist($post);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Un nouvel article a été ajouté'
            );

            return $this->redirectToRoute('app_blog');
        }

        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/post/edit/{id}', name: 'app_edit_post')]
    public function edit(Post $post, EntityManagerInterface $manager, Request $request): Response
    {
        $form  =  $this->createForm(PostType::class, $post);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $path = $this->getParameter('kernel.project_dir') . '/public/images';
            $image = $form->getData()->getImage();
            $image->setPath($path);
            $manager->flush();
            $this->addFlash('notice', "Super ! L'article a bien été modifié");

            return $this->redirectToRoute('app_blog');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/post/{id}', name: 'app_show_post')]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/post/delete/{id}', name: 'app_delete_post')]
    public function delete(Post $post , EntityManagerInterface $manager): Response
    {
        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute('app_blog');
    }
}
