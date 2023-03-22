<?php

namespace App\DataFixtures;

use App\Entity\Domain;
use App\Entity\Lift;
use App\Entity\Slope;
use App\Entity\Station;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $domain = new Domain();
        $domain->setName("espace diamant");
        $domain->setImgUrl("https://picsum.photos/200/300");

        $manager->persist($domain);
        $manager->flush();
        
        foreach(['Les Saisies', 'Crest-Volant Cohennoz', 'Notre-Dame-De-Bellecombe', 'Praz-Sur-Arly','Flumet'] as $name){
            $station = new Station();
            $station->setDomain($domain);
            $station->setName($name);
            $station->setImgUrl("https://picsum.photos/200/300");
            $station->setDescription("Meilleur Station");
            $manager->persist($station);
        };

        
        $manager->flush();

        $stationsRepository = $manager->getRepository(Station::class);
        $stations = $stationsRepository->findAll();


        $transportModes = array("Tapis roulant" , "Tire-fesses","Les télésièges","Les télécabines", "Les téléphériques","Les funiculaires");
        
        foreach($stations as $station){
            $difficulties = array ("Facile", "Facile/Moyen","Moyen","Difficile","Très Difficile");
            foreach(['La verte', 'La bleu', 'La rouge' , 'La Noire', 'La Double Noire'] as $name){
            $slope = new Slope();
            $slope->setName($name);
            $slope->setStation($station);
            $slope->setDifficulty(array_shift($difficulties));
            $slope->setIsOpen(TRUE);
            $slope->setDescription("Meilleur Piste");
            $slope->setType((rand(0, 1) == 1) ? "alpines" : "nordiques");
            $slope->setGrade(rand(1,5));
            $randomSeconds = rand(0, 900);
            $duration = new \DateTime("today + $randomSeconds seconds");
            $slope->setDuration($duration);
            $slope->setPeople(rand(1000,10000));
            $slope->setQuality(rand(1,5));
            $manager->persist($slope);



            };
            
            for ($i = 1; $i <= 5; $i++) {
                $lift = new Lift();
                $lift->setName("Remonté ".$i);
                $lift->setStation($station);
                $lift->setType($transportModes[array_rand($transportModes)]);
                $open = new \DateTime("today + 28800 seconds");
                $close = new \DateTime("today + 64800 seconds");
                $lift->setOpen($open);
                $lift->setClose($close);
                $lift->setDescription("Super remonté");
                $randomSeconds = rand(0, 900);
                $duration = new \DateTime("today + $randomSeconds seconds");
                $lift->setDuration($duration);
                $lift->setGrade(rand(1,5));
                $manager->persist($lift);
            }
        }
        $manager->flush();



    }
}
