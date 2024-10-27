<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\DateRangeType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function addBook(ManagerRegistry $manager, AuthorRepository $repository, Request $req){

        $book = new Book();

        $form = $this->createForm(BookType::class,$book);

       
        $form->handleRequest($req);

        if($form->isSubmitted())
        {
            $em= $manager->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_getallbook');
        }

        return $this->render('book/formBook.html.twig',[

            'f'=>$form->createView()
      
            ]);

    }

    #[Route('/book/getall', name: 'app_getallbooks')]
    public function getAllBooks(Request $request, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(DateRangeType::class);
        $form->handleRequest($request);
    
        // Default to fetching all books
        $books = $bookRepository->findAll();
    
        // Check if the form is submitted and valid for date range filtering
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $startDate = $data['startDate'];
            $endDate = $data['endDate'];
    
            // Fetch books within the specified date range
            $books = $bookRepository->findBooksByDateRange($startDate, $endDate);
        }
    
        return $this->render('book/index.html.twig', [
            'form' => $form->createView(),
            'books' => $books,
        ]);
    }
    


    #[Route('/book/update/{id}', name: 'app_updatebook')]
    public function updateBook(ManagerRegistry $manager, BookRepository $repo, $id, Book $book, Request $req )
    {

        $form = $this->createForm(BookType::class,$book);
        $em = $manager->getManager();
        

        $form->handleRequest($req);

        if($form->isSubmitted())
                    {
                    $em->flush();
                    return $this->redirectToRoute('app_getallbook');
                    }

                    return $this->render('book/formBook.html.twig',[

                        'f'=>$form->createView()
                  
                        ]);
            

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
