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
        // catégorie admin
        $adminCategory = new Category();
        $adminCategory->setLibelle('admin');
        $manager->persist($adminCategory);

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

        // profil admin
        $profile = new Profile();
        $profile->setFirstName('Prénom');
        $profile->setLastName('Nom');
        $profile->setBirthDate(new DateTime());
        $profile->setDisplayedToPeers(false);
        $profile->setEssay('Insert 300 words essay...');
        $profile->setCategory($adminCategory);

        $manager->persist($profile);
        $manager->flush();

        // user administrateur
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('admin@skillhub.com');
        $user->setProfile($profile);
        $user->setIsVerified(true);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'verySecure_1234'));

        $manager->persist($user);
        $manager->flush();
    }
}
