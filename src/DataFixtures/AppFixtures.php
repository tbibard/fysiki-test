<?php

namespace App\DataFixtures;

use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $reviewData = [
            1 => ['title' => 'Nul', 'description' => ''],
            2 => ['title' => 'Bof', 'description' => ''],
            3 => ['title' => 'Bien', 'description' => ''],
            4 => ['title' => 'Super', 'description' => ''],
            5 => ['title' => 'Excellent', 'description' => ''],
        ];

        // create 25 reviews
        for ($i = 0; $i < 25; $i++) {
            $review = new Review();
            $review->setProduct(mt_rand(1, 3));
            $review->setNote(mt_rand(1, 5));
            $review->setTitle('');
            $manager->persist($review);
        }

        $manager->flush();
    }
}
