<?php

namespace App\DataFixtures;
use App\Entity\Category;
use App\Entity\Departement;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $encoder; 

    public function __construct( UserPasswordHasherInterface $encoder)
    {
        
        $this->encoder = $encoder;
        
    }
    public function load(ObjectManager $manager): void
    {
        $superAdmin = new User();
        $hash = $this->encoder->hashPassword($superAdmin, "password");
        $superAdmin->setEmail("admin@gmail.com");
        $superAdmin->setPassword($hash);
        $superAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($superAdmin);
        $manager->flush();

        $user = new User();
        $hash = $this->encoder->hashPassword($user, "password");
        $user->setEmail("user@gmail.com");
        $user->setPassword($hash);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();

        $departement = new Departement();
        $departement->setName('Hérault');
        $departement->setNumber('34');
        $manager->persist($departement);
        $manager->flush();

        $city = new City();
        $city->setName('Montpellier');
        $city->setZipcode('34000');
        $city->setDepartement($departement);
        $manager->persist($city);
        $manager->flush();

        $category = new Category();
        $category->setName('Vegan');
        $manager->persist($category);
        $manager->flush();

    }

    public function generateDepartementData(EntityManagerInterface $entityManager): void
    {
        // Incluez le fichier autoload.php de Composer pour charger Faker
        require_once 'vendor/autoload.php';
    
        // Utilisez la factory pour créer une instance de Faker\Generator
        $faker = Factory::create();
    
        // Générez des données pour la table departement
        for ($i = 0; $i < 3; $i++) { // Générer 3 enregistrements de départements (ajustez selon vos besoins)
            $name = $faker->city; // Générer un nom de département fictif (vous pouvez ajuster le générateur en fonction de vos besoins)
            $number = $faker->numberBetween(1, 99); // Générer un nombre aléatoire entre 1 et 100
            
            // Créez une nouvelle instance de l'entité Departement (adaptez au nom de votre entité)
            $departement = new Departement();
            $departement->setName($name);
            $departement->setNumber($number);
            
            // Persistez l'entité dans la base de données
            $entityManager->persist($departement);
        }
    
        // Enregistrez les enregistrements dans la base de données
        $entityManager->flush();
    }


    public function generateCityData(EntityManagerInterface $entityManager): void
{
    // Incluez le fichier autoload.php de Composer pour charger Faker
    require_once 'vendor/autoload.php';

    // Utilisez la factory pour créer une instance de Faker\Generator
    $faker = Factory::create();

    // Générez des données pour la table city
    for ($i = 0; $i < 3; $i++) { // Générer 3 enregistrements de villes (ajustez selon vos besoins)
        $name = $faker->city; // Générer un nom de ville aléatoire
        $zipCode = $faker->postcode; // Générer un code postal aléatoire
        
        // Créez une nouvelle instance de l'entité City (adaptez au nom de votre entité)
        $city = new City();
        $city->setName($name);
        $city->setZipCode($zipCode);
        
        // Persistez l'entité dans la base de données
        $entityManager->persist($city);
    }

    // Enregistrez les enregistrements dans la base de données
    $entityManager->flush();
}



public function generateRestaurantData(EntityManagerInterface $entityManager): void
{
    // Incluez le fichier autoload.php de Composer pour charger Faker
    require_once 'vendor/autoload.php';

    // Utilisez la factory pour créer une instance de Faker\Generator
    $faker = Factory::create();

    // Générez des données pour la table restaurant
    for ($i = 0; $i < 5; $i++) { // Générer 5 enregistrements de restaurants (ajustez selon vos besoins)
        $name = $faker->company; // Générer un nom de restaurant fictif (vous pouvez ajuster le générateur en fonction de vos besoins)
        $address = $faker->address; // Générer une adresse fictive
        
        // Créez une nouvelle instance de l'entité Restaurant (adaptez au nom de votre entité)
        $restaurant = new Restaurant();
        $restaurant->setName($name);
        $restaurant->setAddress($address);
        
        // Persistez l'entité dans la base de données
        $entityManager->persist($restaurant);
    }

    // Enregistrez les enregistrements dans la base de données
    $entityManager->flush();
}





}
