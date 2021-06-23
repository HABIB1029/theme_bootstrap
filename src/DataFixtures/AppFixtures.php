<?php

namespace App\DataFixtures;

use App\Entity\Announce;
use App\Entity\Comment;
use App\Entity\Image;
//use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Cocur\Slugify\Slugify;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
       $faker = Factory::create("fr_FR");

       $slugger = new Slugify();
        for ($i = 0; $i < 7 ; $i++){

        $announce = new Announce();
        $announce->setTitle($faker->sentence(3, false));
        //$announce->setSlug($slugger->slugify($announce->getTitle()));
        $announce->setDescription($faker->text(200));
        $announce->setPrice(mt_rand(30000,60000));
        $announce->setAdresse($faker->address(3));
        $announce->setImageCover( 'https://www.shbarcelona.fr/blog/fr/wp-content/uploads/2016/03/appartement-photo.jpg',);
        $announce->setRooms(mt_rand(0,5));
        $announce->setIsAvailable(mt_rand(0,1));
        $announce->setCreatAt($faker->dateTimeBetween('-3 month','now'));
        
        for($j = 0; $j < mt_rand(0,7) ; $j++ ){
        $comment = new comment();
        $comment->setAuthor($faker->name())
                ->setEmail($faker->email())
                ->setContent($faker->text(150))
                ->setCreatedAt($faker->dateTimeBetween('-4 month','now'))
                 ->setAnnounce($announce)
                 ;

        $manager ->persist($comment);
        $announce->addComment($comment); //permet à doctrine d'enregistrer dans la BD
    }

    for($k = 0; $k < mt_rand(0,7) ; $k++ ){
        $image = new image();
        $image->setImageUrl($faker->image());
        $image ->setDescription($faker->sentence());
                 ;

        $manager ->persist($image);
        $announce->addImage($image); //permet à doctrine d'enregistrer dans la BD
    }
        $manager->persist($announce);
    }
    $manager->flush();
}

}