<?php

namespace App\Controller;

use App\Form\SearchPostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search/post', name: 'app_search_post')]
    public function searchPost(Request $request, PostRepository $postRepository)
    {
        $posts = [];
        $searchPostForm = $this->createForm(SearchPostType::class);

        if ($searchPostForm->handleRequest($request)->isSubmitted() && $searchPostForm->isValid()) {
            $criteria = $searchPostForm->getData();

            $posts = $postRepository->searchPost($criteria);
        }
        return $this->render('search/post.html.twig', [
            'search_form' => $searchPostForm->createView(),
            'posts' => $posts
        ]);
    }

}