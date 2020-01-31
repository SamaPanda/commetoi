<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController{

    /**
     * @Route("/", name="index")
     */
    public function listAction(RequestStack $request){
        $page = $request->getCurrentRequest()->get('page') ?? 1;
        if(!preg_match("/^\d+$/",$page)){
            $page = 1 ;
        }
        $repository =  $this->getDoctrine()->getRepository(Produit::class);

        /* pagination */
        $products = $repository->paginate($page);
        $count = $repository->count([]);
        $totalPage= ceil($count /12);
        
        return $this->render('list.html.twig',
            ['products' => $products, 'count'=> $count,'total' =>$totalPage, 'current' => $page]
        );
    }

    /**
     * @Route("/book/{product}", name="book_details", requirements={"page"="\d+"})
     */
    public function getAction(Produit $product){
        return $this->render('detail.html.twig', ['product' => $product]);
    }
}