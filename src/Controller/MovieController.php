<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Productor;
use App\Form\MovieFormType;
use App\Form\FilterFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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

        return $this->render('movies/movieAdd.html.twig', [
            'movieForm' => $form,
        ]);
    }

    #[Route('/movies', name: 'movies')]
    public function movies(Request $request, MovieRepository $movieRepository, PaginatorInterface $paginator): Response
    {
        $movies = $movieRepository->findAll();

        $form = $this->createForm(FilterFormType::class, $movies);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movies = $movieRepository->filterMovie(
                $form->get('title')->getData(),
            );
        }

        $pagination = $paginator->paginate(
            $movies,
            $request->query->get('page', 1),
            2
        );

        return $this->render('movies/movies.html.twig', [
            'pagination' => $pagination,
            'form' => $form,
        ]);
    }

    #[Route('/movies/modify/{id}', name: 'movies_modify')]
    public function movieModify(int $id, Request $request, MovieRepository $movieRepository, EntityManagerInterface $entityManager): Response
    {
        $movie = $movieRepository->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Le film n\'existe pas');
        }

        $form = $this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/movieModify.html.twig', [
            'movieForm' => $form,
        ]);
    }

    #[Route('/movies/delete/{id}', name: 'movies_delete')]
    public function movieDelete(int $id, MovieRepository $movieRepository, EntityManagerInterface $entityManager): Response
    {
        $movie = $movieRepository->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Le film n\'existe pas');
        }

        $entityManager->remove($movie);
        $entityManager->flush();

        return $this->redirectToRoute('movies');
    }

    #[Route('/movies/view/{id}', name: 'movies_view')]
    public function movieView(int $id, Request $request, MovieRepository $movieRepository, EntityManagerInterface $entityManager): Response
    {
        $movie = $movieRepository->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Le film n\'existe pas');
        }

        return $this->render('movies/movieView.html.twig', [
            'movie' => $movie,
        ]);
    }
}
