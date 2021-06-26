<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Competence;
use App\Entity\Profile;
use App\Entity\ProfileCompetence;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; // oui deprecated depuis 5.3 y'a 2 semaines... ON SAIT !!

/**
 * WARNING : mt_rand() à fond, zéro scrupules !!
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
// Pour purger les fixtures /!\ supprime et reconstruit tout la base de données
    //symfony console doctrine:database:drop --force
    //symfony console doctrine:database:create
    //symfony console doctrine:migrations:migrate
    //symfony console doctrine:fixtures:load


    public const COMPETENCE_LIST = [
        'lire sur les lèvres',
        'identifier les plantes commestibles',
        'faire du bon café',
        'ponctualité irréprochable',
        'saluer chaleureusement',
        'inclusivité non discriminante',
        'télékinésie',
        '"agilité" verbale',
        'réparer l\'imprimante',
        'débuguer le truc',
        'programmer sous Windowb',
        'jonglage',
        'selfies',
        'résistance accrue aux poisons',
        'changer d\'onglet plus vite que l\'éclair',
        'regard noir',
        'lecture rapide',
        'sommeil polyphasique',
        'exorcisme',
        'surfer sur les internets',
        ''
    ];

    public const COMPANIES_LIST = [
        'McDonald\'s',
        'KFC',
        'Subway',
        'Pizza Hut',
        'Quick',
        'Burger King',
        'Starbucks'
    ];

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // catégories de profils /!\ n'est pas tout à fait équivalent aux rôles
        $categories = ['admin', 'commercial', 'collaborateur', 'candidat'];

        foreach ($categories as $category) {
            $newCategory = new Category();
            $newCategory->setLibelle($category);
            $manager->persist($newCategory);
        }

        // catégories de compétences
        for ($i = 1; $i <= 4; $i++) {
            $category = new Category();
            $category->setLibelle('categoryFixture_' . $i);
            $manager->persist($category);
        }
        $manager->flush();

        // compétences
        foreach(self::COMPETENCE_LIST as $intitule) {

            $competence = new Competence();
            $competence->setLibelle($intitule);

            /** @var Category $category */
            $category = $manager->getRepository(Category::class)->findOneBy(['libelle' => 'categoryFixture_' . mt_rand(1, 4)]);
            $competence->setCategory($category);
            $manager->persist($competence);
        }
        $manager->flush();

        // entreprises
        foreach(self::COMPANIES_LIST as $companyName) {

            $entreprise = new Company();
            $entreprise->setName($companyName);
            $manager->persist($entreprise);
        }
        $manager->flush();

        // admin profil
        $profile = new Profile();
        $profile->setFirstName('Anon');
        $profile->setLastName('Mundi');
        $profile->setBirthDate(new DateTime());
        $profile->setDisplayedToPeers(true);
        $profile->setEssay('Insert 300 words essay...');
        $profile->setCategory($manager->getRepository(Category::class)->findOneByLibelle('admin'));

        $profile = $this->loadProfileCompetences($profile, $manager);
        $manager->persist($profile);
        $manager->flush();

        // admin user
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('admin@skillhub.com');
        $user->setProfile($profile);
        $user->setIsVerified(true);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'verySecure_1234'));

        $manager->persist($user);
        $manager->flush();

        $profile->setUser($user);
        $manager->persist($profile);
        $manager->flush();

        // commercial profil
        $profile = new Profile();
        $profile->setFirstName('Manu');
        $profile->setLastName('Micron');
        $profile->setBirthDate(new DateTime());
        $profile->setDisplayedToPeers(true);
        $profile->setEssay('Parce que c\'est notre... PROJEEEEET !!!');
        $profile->setCategory($manager->getRepository(Category::class)->findOneByLibelle('commercial'));

        $this->loadProfileCompetences($profile, $manager);
        $manager->persist($profile);
        $manager->flush();

        // commercial user
        $user = new User();
        $user->setRoles(['ROLE_COMMERCIAL']);
        $user->setEmail('micron.commercial@skillhub.com');
        $user->setProfile($profile);
        $user->setIsVerified(true);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'laBaffe100'));

        $manager->persist($user);
        $manager->flush();

        $profile->setUser($user);
        $manager->persist($profile);
        $manager->flush();


        // collaborateur profil
        $profile = new Profile();
        $profile->setFirstName('Maxime');
        $profile->setLastName('Aubé');
        $profile->setBirthDate(new DateTime());
        $profile->setDisplayedToPeers(false);
        $profile->setEssay('Je fais un ECF en Symfony');
        $profile->setCategory($manager->getRepository(Category::class)->findOneByLibelle('collaborateur'));

        $this->loadProfileCompetences($profile, $manager);
        $manager->persist($profile);
        $manager->flush();

        // collaborateur user
        $user = new User();
        $user->setRoles(['ROLE_COLLABORATEUR']);
        $user->setEmail('aube.collaborateur@skillhub.com');
        $user->setProfile($profile);
        $user->setIsVerified(true);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'keepCalm&h8'));

        $manager->persist($user);
        $manager->flush();

        $profile->setUser($user);
        $manager->persist($profile);
        $manager->flush();

        // candidat profiles
        for ($i = 1; $i <= 10; $i++) {
            $profile = new Profile();
            $profile->setFirstName('Prénom_' . $i);
            $profile->setLastName('Nom_' . $i);
            $profile->setBirthDate(new DateTime());
            $profile->setDisplayedToPeers(false); // peu importe pour les candidats
            $profile->setEssay('Je suis un candidat original et j\'en veux !');
            $profile->setCategory($manager->getRepository(Category::class)->findOneByLibelle('candidat'));

            $this->loadProfileCompetences($profile, $manager);
            $manager->persist($profile);
        }

        $manager->flush();
    }

    // ajoute nombre aléatoire de compétences sur ce profil
    private function loadProfileCompetences(Profile $profile, ObjectManager $manager) {

        for ($i = 0; $i < mt_rand(1, 15); $i++) {

            $profileCompetence = new ProfileCompetence();
            $profileCompetence->setProfile($profile);
            $profileCompetence->setCompetence($manager->getRepository(Competence::class)->findOneById(mt_rand(1, count(self::COMPETENCE_LIST))));
            $profileCompetence->setLevel(mt_rand(1,5));
            $profileCompetence->setLiked(mt_rand(0, 1));

            $profile->addProfileCompetence($profileCompetence);
            $manager->persist($profileCompetence);
        }
        return $profile;
    }
}
