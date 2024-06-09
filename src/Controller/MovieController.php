<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Productor;
use App\Form\MovieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movies/add', name: 'movies_add')]
    public function movieAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/movie.html.twig', [
            'movieForm' => $form,
        ]);
    }
}
