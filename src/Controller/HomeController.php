<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RecipeRepository $recipeRepository, CategoryRepository $categoryRepository): Response
    {

        $recipes = $recipeRepository->findBy([], ['created_at' => 'DESC'], 5);

        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [

            'recipes' => $recipes,
            'categories' => $categories
            
        ]);
    }
}
