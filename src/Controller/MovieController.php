<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Productor;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
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

            return $this->redirectToRoute('movies_view');
        }

        return $this->render('movies/movieAdd.html.twig', [
            'movieForm' => $form,
        ]);
    }
    #[Route('/movies', name: 'movies_view')]
    public function movieView(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();
        return $this->render('movies/movieView.html.twig', [
            'movies' => $movies,
        ]);
    }
}
