<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Utils\Cart;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart, Request $request): Response
    {
        if(!$this->getUser()->getAddresses()->getValues()){
            return $this->redirectToRoute('account_address_add');
        }
        $form =  $this->createForm(OrderType::class,null,[
            'user'=>$this->getUser()
        ]);
      
        return $this->render('order/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=>$cart->getFull()
        ]);
    }

     /**
     * @Route("/commande/ajouter", name="order_recap",methods={"POST"})
     */
    public function add(Cart $cart, Request $request): Response
    {
        
        $form =  $this->createForm(OrderType::class,null,[
            'user'=>$this->getUser()
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //enregistrer order
            $date=new DateTime();
            $carriers = $form->get('carriers')->getData();
            $delivery=$form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
    
            if($delivery->getCompany())
            {
                $delivery_content .='<br/>'.$delivery->getCompany();
            }
            $delivery_content.='<br/>'.$delivery->getAddress();
            $delivery_content.='<br/>'.$delivery->getZipcode().' '.$delivery->getCity();
            $delivery_content.='<br/>'.$delivery->getCountry();

            $order = new Order();
            $order->setCustomer($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(false);
            $this->entityManager->persist($order);

             //enregister order_details
            foreach ($cart->getFull() as $product ) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product->getName());
                $orderDetails->setQuantity($product->quantity);
                $orderDetails->setPrice($product->getPrice());
                $this->entityManager->persist($orderDetails);
            } 
            $this->entityManager->flush();
            return $this->render('order/add.html.twig',[
                'cart'=>$cart->getFull(),
                'carrier'=>$carriers,
                'delivery'=>$delivery_content
            ]);
        }
        return $this->redirectToRoute('cart');
        
    }

    /**
     * @Route("/commande/mes-commandes", name="orders_list")
     */
    public function all(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessfullOrders($this->getUser());
        return $this->render('order/all.html.twig',[
            'orders'=>$orders
        ]);
    }

    /**
     * @Route("/commande/mes-commandes/{reference}", name="order_show")
     */
    public function show($reference): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['reference'=>$reference]);
        if($order->getCustomer() !== $this->getUser()){
            $this->redirectToRoute('orders_list');
        }
        return $this->render('order/show.html.twig',[
            'order'=>$order
        ]);
    }
}
