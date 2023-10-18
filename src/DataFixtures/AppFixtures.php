<?php

namespace App\DataFixtures;

use App\Entity\Session;
use DateTime;
use Faker\Factory;
use App\Entity\Tag;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // Init de faker
        $faker = Factory::create('fr_FR');

        // Création de 5 tags
        for($c=0; $c<5; $c++){

            $tag = new Tag;

            $tag->setName($faker->colorName());

            $manager->persist($tag);
        }

        //Création de 3 users
        for($c=0; $c<3; $c++){

            $user = new User;

            $user->setName($faker->name());

            $manager->persist($user);
        }

        $manager->flush();

        //Récupération des tag crées
        $allTags = $manager->getRepository(Tag::class)->findAll();
        $allUser = $manager->getRepository(User::class)->findAll();

        //Création de 3 sessions
        for($c=0; $c<3; $c++){

            $session = new Session;

            $session->setUser($faker->randomElement($allUser))
                ->setCreatedAt(new \DateTime())
                ->setFinishedAt($faker->dateTimeBetween('now', 'tomorrow'));

            $manager->persist($session);
        }
        $manager->flush();

        $allSession = $manager->getRepository(Session::class)->findAll();

        // Création des task entre 15 et 30 random
        for ($t = 0; $t < mt_rand(15,30); $t++){
            
            // Création d'un nouvel objet tache
            $task = new Task;

            // On nourrit l'objet Task
            $task->setName($faker->sentence(6))
                ->setDescription($faker->paragraph(3))
                ->setCreatedAt(new \DateTime()) // Attention les dates sont créees en fonction du reglages serv
                ->setDueAt($faker->dateTimeBetween('now', '6 months')) // Date en fonction du serv
                ->setTag($faker->randomElement($allTags))
                ->setUser($faker->randomElement($allUser))
                ->setSession($faker->randomElement($allSession));

            // On persiste l'objet pour le préparer à l'enregistrement dans BDD
            $manager->persist($task);

        }

        $manager->flush();
    }
}
