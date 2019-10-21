<?php

namespace App\Controller;

use App\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->forward('App\Controller\ProductController::index', [
            'controller_name' => 'DefaultController',
        ]);
    }

//    /**
//     * @Route("/test", name="test")
//     */
//    public function test(MailerInterface $mailer)
//    {
//        $email = (new Email())
//            ->from('tomskab@neblion.net')
//            ->to('thomas.bibard@neblion.net')
//            //->cc('cc@example.com')
//            //->bcc('bcc@example.com')
//            //->replyTo('fabien@example.com')
//            //->priority(Email::PRIORITY_HIGH)
//            ->subject('Time for Symfony Mailer!')
//            ->text('Sending emails is fun again!')
//            ->html('<p>See Twig integration for better HTML integration!</p>');
//
//        $mailer->send($email);
//
//        dump($this->getParameter('kernel.environment'));
//
//        return $this->render('default/index.html.twig', [
//            'controller_name' => 'DefaultController',
//        ]);
//    }
}
