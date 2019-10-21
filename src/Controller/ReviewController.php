<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/review")
 */
class ReviewController extends AbstractController
{
    /**
     * @Route("/{id}", name="review_list", methods={"GET"}, condition="request.isXmlHttpRequest()")
     */
    public function list(Request $request, ReviewRepository $reviewRepository, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tri = $request->query->get('tri', 'date');
        $filter = $request->query->get('filter', null);

        $reviews = $entityManager->getRepository('App:Review')->getList($id, $tri, $filter);

        // Calculate avg
        $sum = $avg = 0;
        if (count($reviews) > 0) {
            foreach ($reviews as $review) {
                $sum += $review['note'];
            }
            $avg = round($sum/count($reviews));
        }

        return $this->render('review/list.html.twig', [
            'reviews' => $reviews,
            'avg'     => $avg,
        ]);
    }

    /**
     * @Route("/{id}/new", name="review_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $id): Response
    {
        $review = new Review();
        $review->setProduct($id);
        $form = $this->createForm(ReviewType::class, $review, [
            'action' => $this->generateUrl('review_new', ['id' => $id]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($review);
                $entityManager->flush();

                return $this->redirectToRoute('product_show', ['id' => $id]);
            }

            return $this->render('review/new.html.twig', [
                'review'  => $review,
                'product' => ProductController::PRODUCTS[$id],
                'form'   => $form->createView(),
            ], new Response('Form error', Response::HTTP_PRECONDITION_FAILED));
        }

        return $this->render('review/new.html.twig', [
            'review'  => $review,
            'product' => ProductController::PRODUCTS[$id],
            'form'    => $form->createView(),
        ]);
    }
}
