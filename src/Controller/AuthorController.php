<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/add', name: 'app_addauthor')]
    public function addAuthor(ManagerRegistry $manager)
    {
        $em= $manager->getManager();
        $author1 = new Author();
        $author1->setUsername('eya');
        $author1->setEmail('eya@esprit.com'); 
        
        $em->persist($author1);
        $em->flush();
        return new Response ('Author added');
    }

    #[Route('/author/getall', name: 'app_getallauthor')]
    public function getAllAuthor(AuthorRepository $repository)
    {
        $authors = $repository->findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors 

        ]);

    }

    #[Route('/author/update/{id}', name: 'app_updateauthor')]
    public function updateAuthor(ManagerRegistry $manager, AuthorRepository $repo, $id )
    {
        $em= $manager->getManager();
        $author1 = $repo->find($id);
        $author1->setUsername('girly');

        $em->flush();

        return new Response ('Author edited');
    }


    #[Route('/author/delete/{id}', name: 'app_deleteauthor')]
    public function deleteAuthor(ManagerRegistry $manager, AuthorRepository $repo, $id )
    {
        $em= $manager->getManager();
        $author = $repo->find($id);
      
        $em->remove($author)  ;
        $em->flush();

        return $this->redirectToRoute('app_getallauthor');
    }

}
