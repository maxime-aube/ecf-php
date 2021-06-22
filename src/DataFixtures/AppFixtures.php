<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Competence;
use App\Entity\Profile;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; // oui deprecated depuis 5.3 y'a 2 semaines... ON SAIT !!


class AppFixtures extends Fixture
{
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
        for ($i = 1; $i <= 10; $i++) {

            $competence = new Competence();
            $competence->setLibelle('competenceFixture_' . $i);

            /** @var Category $category */
            $category = $manager->getRepository(Category::class)->findOneBy(['libelle' => 'categoryFixture_' . mt_rand(1, 4)]);
            $competence->setCategory($category);
            $manager->persist($competence);
        }
        $manager->flush();

        // admin profil
        $profile = new Profile();
        $profile->setFirstName('Prénom');
        $profile->setLastName('Nom');
        $profile->setBirthDate(new DateTime());
        $profile->setDisplayedToPeers(true);
        $profile->setEssay('Insert 300 words essay...');
        $profile->setCategory($manager->getRepository(Category::class)->findOneByLibelle('admin'));

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
            $manager->persist($profile);
        }

        $manager->flush();
    }
}
