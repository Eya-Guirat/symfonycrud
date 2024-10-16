<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/book/add', name: 'app_addbook')]
    public function addBook(ManagerRegistry $manager){
        $em= $manager->getManager();
        $book1 = new Book();
        $book1->setTitle('The Corpse in the Night');
        $book1->setPublicationDate(new \DateTime('2024-01-01'));
        $book1->setEnabled('true');

        $book2 = new Book();
        $book2->setTitle('Sign of the Burnt Turnip');
        $book2->setPublicationDate(new \DateTime('2024-02-02'));
        $book2->setEnabled('true');

        $em->persist($book2);
        $em->flush();
        return new Response ('Book added');
    }

    #[Route('/book/getall', name: 'app_getallbook')]
    public function getAllBook(BookRepository $repository)
    {
        $books = $repository->findAll();
        return $this->render('book/index.html.twig', [
            'books' => $books 

        ]);

    }


    #[Route('/book/update/{id}', name: 'app_updatebook')]
    public function updateBook(ManagerRegistry $manager, BookRepository $repo, $id )
    {
        $em = $manager->getManager();
        $book1 = $repo->find($id);
        $book1->setTitle('The Jumping Clock');

        $em->flush();

        

        return new Response ('Book edited');
    }


    #[Route('/book/delete/{id}', name: 'app_deletebook')]
    public function deleteBook(ManagerRegistry $manager, BookRepository $repo, $id )
    {
        $em= $manager->getManager();
        $book = $repo->find($id);
      
        $em->remove($book)  ;
        $em->flush();

        return $this->redirectToRoute('app_getallbook');
    }

}
