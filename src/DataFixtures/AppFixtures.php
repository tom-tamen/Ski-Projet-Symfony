<?php

namespace App\DataFixtures;

use App\Entity\Challenge;
use App\Entity\Domain;
use App\Entity\Faq;
use App\Entity\Lift;
use App\Entity\Slope;
use App\Entity\Station;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Length;

class AppFixtures extends Fixture
{
    
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasherInterface
    )
    {

    }
    public function load(ObjectManager $manager): void
    {
        foreach(["Espace Diamant","Les 3 vallées"] as $name){
            $domain = new Domain();
            $domain->setName($name);
            if ($name == "Espace Diamant"){
                $domain->setImgUrl("logo-espacediamant.png");
            }else{
                $domain->setImgUrl("Logo_Les_3_Vallées.png");
            }
            $manager->persist($domain);
        }
        

        $user = new User();
        $user->setEmail("email.admin@gmail.com");
        $user->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user,"admin"));
        $manager->persist($user);
        $manager->flush();

        $domainRepository = $manager->getRepository(Domain::class);
        $domains = $domainRepository->findAll();
        $x = 0;
        foreach($domains as $domain){
            
            foreach(['Les-Saisies', 'Crest-Volant Cohennoz', 'Notre-Dame-De-Bellecombe', 'Praz-Sur-Arly','Flumet'] as $name){
                $user = new User();
                $user->setEmail($x.$name."@gmail.com");
                $user->setPassword($this->userPasswordHasherInterface->hashPassword(
                    $user,$x.$name));
                $user->setRoles(['ROLE_ADMIN']);
                $manager->persist($user);
                $station = new Station();
                $station->setDomain($domain);
                $station->setName($name);
                $station->setImgUrl("https://picsum.photos/200/300");
                $station->setDescription("Meilleur Station");
                $station->setOwner($user);
                $manager->persist($station);
            };
            $x++;   
    
            
            $manager->flush();
    
            $stationsRepository = $manager->getRepository(Station::class);
            $stations = $stationsRepository->findAll();
    
    
            $transportModes = array("Tapis roulant" , "Tire-fesses","Les télésièges","Les télécabines", "Les téléphériques","Les funiculaires");
            
            foreach($stations as $station){
                $difficulties = array ("Verte", "Bleu","Rouge","Noir","Double Noir");
                $nameslope = ["Beaufortaine","Ecureuils","Choucas","Hirondelles","Chamois","Girolles","Perdrix","Lezette","Barme","Trolliers","Thuile","Renard","Reguet","Les Prés"];
                $namelift = ['Vores',"Plan Des Fours" , "Bellasta","Ban Rouge","Evettes","Reguet","Lachat","Logère"];
                for ($i = 1; $i <= 5; $i++){   
                    $slope = new Slope();
                    $slope->setStation($station);
                    $slope->setDifficulty($difficulties[rand(0,4)]);
                    $random = rand(0, count($nameslope) - 1);
                    $slope->setName($nameslope[$random]);
                    array_splice($nameslope, $random, 1);
                    $slope->setIsOpen(TRUE);
                    $slope->setDescription("Meilleur Piste");
                    $slope->setType((rand(0, 1) == 1) ? "alpines" : "nordiques");
                    $slope->setGrade(rand(1,5));
                    $randomSeconds = rand(100, 900);
                    $duration = new \DateTime("today + $randomSeconds seconds");
                    $slope->setDuration($duration);
                    $slope->setPeople(rand(1000,10000));
                    $qualities = array ("Mauvais état", "Etat moyen", "Bon état");
                    $slope->setQuality($qualities[array_rand($qualities)]);
                    $manager->persist($slope);
                };
                for($i = 1; $i <=5; $i++){
                    $question = ['Comment puis-je louer du matériel de ski ?',"Comment puis-je acheter un forfait de ski ?","Comment puis-je trouver le chemin le plus court pour descendre de la montagne ?","Comment puis-je éviter les foules sur les pistes ?","Comment puis-je savoir si les pistes sont ouvertes ou fermées ?","Comment puis-je me réchauffer si j'ai froid ?","Comment puis-je éviter les blessures en ski ?","Comment puis-je trouver un moniteur de ski pour m'apprendre à skier ?"];
                    $answer = ["Rendez-vous dans un magasin de location de ski et remplissez un formulaire de location. Ils vous fourniront ensuite l'équipement dont vous avez besoin.","Vous pouvez acheter un forfait de ski en ligne ou à la billetterie de la station de ski.","Suivez les panneaux de signalisation et les pistes balisées pour trouver votre chemin de descente.","Essayez de skier en dehors des heures de pointe ou explorez les pistes moins connues de la station de ski.","Vérifiez les bulletins d'enneigement de la station de ski ou les panneaux d'information sur les pistes pour savoir quelles pistes sont ouvertes ou fermées.","Arrêtez-vous dans un refuge ou un restaurant de montagne pour vous réchauffer avec une boisson chaude et des collations.","Portez un équipement de protection approprié, skiez à votre niveau et respectez les règles de sécurité sur les pistes.","Rendez-vous à l'école de ski de la station de ski et demandez un moniteur de ski pour une leçon privée ou en groupe."];
                    $faq = new Faq();
                    $faq->setStation($station);
                    $random = rand(0,count($question)-1);   
                    $faq->setQuestion($question[$random]);
                    $faq->setAnswer($answer[$random]);
                    unset($question[$random]);
                    unset($answer[$random]); 
                    $manager->persist($faq);
                }
                
                for ($i = 1; $i <= 3; $i++) {
                    $lift = new Lift();
                    $random = rand(0, count($namelift) - 1);
                    $lift->setName($namelift[$random]);
                    array_splice($namelift, $random, 1);
                    $lift->setStation($station);
                    $lift->setType($transportModes[array_rand($transportModes)]);
                    $open = new \DateTime("today + 28800 seconds");
                    $close = new \DateTime("today + 64800 seconds");
                    $lift->setOpen($open);
                    $lift->setClose($close);
                    $lift->setDescription("Super remonté");
                    $randomSeconds = rand(100, 900);
                    $duration = new \DateTime("today + $randomSeconds seconds");
                    $lift->setDuration($duration);
                    $lift->setGrade(rand(1,5));
                    $manager->persist($lift);
                }
            }
    
            $challenge = new Challenge();
            $challenge->setImgUrl("https://picsum.photos/200/300");
            $challenge->setName("Challenge");
            $challenge->setDescription("Le meilleur des challenges");
            $manager->persist($challenge);
    
            $manager->flush();  
        };
        
        

    }
}
