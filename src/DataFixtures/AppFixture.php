<?php


namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixture extends Fixture
{
    private $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        //load genre
        for ($i = 0; $i < 15; $i++) {
            $genre = new Genre();
            $genre->setName($this->faker->word());
            $this->manager->persist($genre);
            $this->addReference( 'genre_' . $i, $genre);
        }

        //load produits
        for ($i = 0; $i < 50; $i++) {
            $product = new Produit();
            $product->setTitle($this->faker->realText(30));
            $product->setType('papier');
            $product->setCountry($this->faker->countryISOAlpha3);
            $product->setDescription($this->faker->sentence(25));
            $product->addGenre($this->getRandomGenre());
            $product->addGenre($this->getRandomGenre());
            $product->setYear($this->faker->year('now'));
            $product->setPrice($this->faker->randomFloat(1,10,30));
            $product->setRanking(5);
            $this->manager->persist($product);
            if($product->getCountry() !== 'FRA'){
             $product->setOriginalTitle($this->faker->sentence(3));
            }
        }

        $manager->flush();
    }

    protected function getRandomGenre() {
        $i = rand(0,14);
        return $this->getReference('genre_'.$i);
    }

}