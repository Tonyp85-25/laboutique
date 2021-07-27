<?php

namespace App\Utils;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(RequestStack $requestStack,EntityManagerInterface $entityManager)
    {
        $this->session= $requestStack->getSession();
        $this->entityManager=$entityManager;
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function add($id)
    {
        $cart= $this->session->get('cart',[]);
        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] =1;
        }
        $this->session->set('cart',$cart);
    }

    public function remove()
    {
        $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart= $this->session->get('cart',[]);
        unset($cart[$id]);
        return $this->session->set('cart',$cart);
    }

    public function reduce($id)
    {
        $cart= $this->session->get('cart',[]);
        if(!$cart[$id]){
            return;
        }else{
            $cart[$id]--;
        }
        if($cart[$id]=== 0){
            unset($cart[$id]);
        }
     
        return $this->session->set('cart',$cart);
    }

    public function getFull()
    {
        $products=[];
        $userCart =$this->get();

        if($userCart){
            $ids = array_keys($userCart);
            $products = $this->entityManager->getRepository(Product::class)->findSelectedProducts($ids); //optimization : only one request to get products in user's cart
            if(count($products)>0){
                foreach ($products as $product) {
                    $product->quantity = $userCart[$product->getId()];                  
                }  
            }else{
                $this->remove();
            }
        }
     
        
        return $products;
        
       
    }

}