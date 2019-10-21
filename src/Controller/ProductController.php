<?php

namespace App\Controller;

use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    const PRODUCTS = [
        1 => [
            'id'          => 1,
            'title'       => 'Product 1',
            'description' => 'Description 1',
            'price'       => 1,
        ],
        2 => [
            'id'          => 2,
            'title'       => 'Product 2',
            'description' => 'Description 2',
            'price'       => 2,
        ],
        3 => [
            'id'          => 3,
            'title'       => 'Product 3',
            'description' => 'Description 3',
            'price'       => 3,
        ],
    ];

    /**
     * @Route("/", name="product_list")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'products' => self::PRODUCTS,
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reviews = $entityManager->getRepository('App:Review')->getList($id, 'date');

        // Calculate avg
        $sum = $avg = 0;
        if (count($reviews) > 0) {
            foreach ($reviews as $review) {
                $sum += $review['note'];
            }
            $avg = round($sum/count($reviews));
        }

        return $this->render('product/show.html.twig', [
            'product' => self::PRODUCTS[$id],
            'reviews' => $reviews,
            'avg'     => $avg,
        ]);
    }
}
