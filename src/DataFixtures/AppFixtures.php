<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    //1° dans Cmder : php bin/console doctrine:schema:drop --force
    //2° dans Cmder : php bin/console doctrine:schema:update --force
    //3° dans Cmder : php bin/console doctrine:fixtures:load mettre yes

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $site = new Site();
        $site->setNomSite('Saint-Herblain');
        $site2 = new Site();
        $site2->setNomSite('Rennes');

        $manager->persist($site);
        $manager->persist($site2);

        $admin = new User();
        $admin->setNoSite($site);
        $admin->setPseudo("Admin");
        $admin->setEmail("admin@campus-eni.fr");
        $admin->setNom("Yoda");
        $admin->setPrenom('Baby');

        $hash = $this->passwordEncoder->encodePassword($admin, 'Pa$$w0rd');
        $admin->setPassword($hash);
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setTelephone("0102030405");

        $manager->persist($admin);


        for ($i = 0; $i < 5; $i++) {

            $user = new User();
            $user->setNoSite($faker->randomElement([$site, $site2]));
            $user->setPseudo($faker->userName);
            $user->setPrenom($faker->firstName);
            $user->setNom($faker->lastName);
            $user->setEmail($user->getPrenom() . "." . $user->getNom() . $faker->year('now') . "@campus-eni.fr");
            $user->setRoles(["ROLE_USER"]);
            $user->setTelephone('0102030405');
            $hash = $this->passwordEncoder->encodePassword($user, 'Pa$$w0rd');
            $user->setPassword($hash);
            $manager->persist($user);


        }

        $ville = new Ville();
        $ville->setNomVille('Nantes');
        $ville->setCodePostal('44400');

        $ville2 = new Ville();
        $ville2->setNomVille('Saint-Herblain');
        $ville2->setCodePostal('44300');

        $manager->persist($ville);
        $manager->persist($ville2);

        for ($i = 0; $i < 10; $i++) {
            $lieu = new Lieu();
            $lieu->setNomLieu('Lieu' . ($i + 1));
            $lieu->setNoVille($faker->randomElement([$ville, $ville2]));
            $lieu->setRue('Rue ' . $faker->name);
            $lieu->setLongitude($faker->numberBetween(0, 40));
            $lieu->setLatitude($faker->numberBetween(0, 40));
            $manager->persist($lieu);
        }


        $etat = new Etat();
        $etat2 = new Etat();
        $etat3 = new Etat();
        $etat4 = new Etat();
        $etat5 = new Etat();
        $etat->setLibelle('En création');
        $etat2->setLibelle('Ouvert');
        $etat3->setLibelle('Fermé');
        $etat4->setLibelle('En cours');
        $etat5->setLibelle('Annulé');
        $manager->persist($etat);
        $manager->persist($etat2);
        $manager->persist($etat3);
        $manager->persist($etat4);
        $manager->persist($etat5);
        $manager->flush();

        $lieux = $manager->getRepository(Lieu::class)->findAll();
        $orga = $manager->getRepository(User::class)->findAll();
        $sites = $manager->getRepository(Site::class)->findAll();
        $etats = $manager->getRepository(Etat::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $sortie = new Sortie();
            $sortie->setNom('Sortie' . ($i + 1));
            $sortie->setNoLieu($faker->randomElement($lieux));
            $sortie->setNoOrganisateur($faker->randomElement($orga));
            $sortie->setNoSite($faker->randomElement($sites));
            $datedebut = $faker->dateTimeBetween('now', '+4 months');
            $sortie->setNoEtat($faker->randomElement($etats));
            $sortie->setDateDebut($datedebut);
            $datefin = $faker->dateTimeBetween('-10 days', $datedebut);
            $sortie->setDateCloture($datefin);
            $sortie->setDuree(4);
            $sortie->setDescriptionInfos($faker->sentence($nbWords = 6, $variableNbWords = true));
            $sortie->setNbInscriptionMax(rand(5, 30));
            $manager->persist($sortie);

//            $inscription = new Inscription();
//            $inscription->setNoSortie($sortie);
//            $inscription->setNoUser($faker->randomElement($orga));
//
//            $inscription->setDateInscription($faker->dateTimeBetween('now', '+30 days'));
//            $manager->persist($inscription);
        }

        $manager->flush();

        $sorties = $manager->getRepository(Sortie::class)->findAll();
//
//        $inscription = new Inscription();
//        $inscription->setNoSortie($faker->randomElement($sorties));
//        $inscription->setNoUser($faker->randomElement($orga));
//
//        $inscription->setDateInscription($faker->dateTimeBetween('now', '+30 days'));
//        $manager->persist($inscription);


        for ($i = 0; $i < 10; $i++) {
            $inscription = new Inscription();
            $inscription->setNoUser($faker->randomElement($orga));
            $inscription->setNoSortie($faker->randomElement($sorties));
            $inscription->setDateInscription($faker->dateTimeBetween('now', '+30 days'));
            $manager->persist($inscription);
        }
        try {

            $manager->flush();
}catch (\Exception $e) {
            // Erreur, animal passé
        }

    }
}