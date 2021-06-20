<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
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
    }
}
