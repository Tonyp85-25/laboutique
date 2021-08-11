<?php

namespace App\Controller;

use App\Entity\Product;
use App\Utils\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager =$entityManager;
    }
    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
    //   $userCart =$cart->get();
    //   $ids = array_keys($userCart);
    //   $products = $this->entityManager->getRepository(Product::class)->findSelectedProducts($ids); //optimization : only one request to get products in user's cart
     
    //   if(count($products)>0){
    //     foreach ($products as $product) {
    //         $product->quantity = $userCart[$product->getId()];
            
    //     }
    //   }
    $products=$cart->getFull();
        return $this->render('cart/index.html.twig', [
            'cart' =>  $products
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete_cart_item")
     */
    public function delete(Cart $cart,$id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/reduce/{id}", name="reduce_cart_item")
     */
    public function reduce(Cart $cart,$id): Response
    {
        $cart->reduce($id);
        return $this->redirectToRoute('cart');
    }
}
