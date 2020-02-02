<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    /**
     * @Route("/cart", name="cart")
     */
    public function cartAction(SessionInterface $session){
        $cart = (array)json_decode($session->get('cart', ""));
        $products = $this->getDoctrine()->getRepository(Produit::class)->findCart($cart);
        $total = 0;

        foreach($products as $product){
            /** @var $product Produit **/
            $total += $product->getPrice() * $cart[$product->getId()];
        }
        return $this->render('cart.html.twig', ['products' => $products, 'cart' => $cart, 'total' => $total]);
    }

    /**
     * @Route("/cart/empty", name="emptyCart")
     */
    public function emptyCartAction(SessionInterface $session){
        $session->remove('cart');
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/cart/ajax", methods={"POST","GET"}, name="cart_ajax")
    */
    public function cartAjaxAction(SessionInterface $session, RequestStack $request){
        if(!$request->getCurrentRequest()->isXmlHttpRequest()) {
            return $this->forward('App\Controller\ShopController::cartAction');
        }
        if($request->getCurrentRequest()->getMethod() === 'POST'){
            $cart = $request->getCurrentRequest()->getContent();
            $session->set('cart', $cart);
        }
        $cart = $session->get('cart') ? $session->get('cart') : null ;
        return new Response($cart);
    }
}