<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct
    (
        private UserPasswordHasherInterface $passwordHasher,
        private CustomerRepository $customerRepository
    ){}

    private function array_random($array, $amount = 1)
    {
        $keys = array_rand($array, $amount);

        if ($amount == 1) {
            return $array[$keys];
        }

        $results = [];
        foreach ($keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 15; ++$i) {
            $product = new Product();
            $product->setName('Produit ' . $i);
            $product->setPrice(random_int(100, 600));
            $product->setDescription('Description du produit');
            $product->setColor($this->array_random(['Jaune', 'Noir', 'Blanc', 'Rouge', 'Vert']));
            $product->setStorage($this->array_random(['32GO', '64GO', '128GO']));
            $manager->persist($product);
            $manager->flush();
        }

        for ($i = 1; $i <= 3; ++$i) {
            $customer = new Customer();
            $customer->setName('Customer ' . $i);
            $customer->setEmail('customer-' . $i . '@bilemo.fr');
            $customer->setPassword($this->passwordHasher->hashPassword($customer, 'password'));
            $customer->setAdress(rand('1', '99') . $this->array_random(['rue', 'avenue']) .' de la '. $this->array_random(['Liberté', 'Paix', 'Mairie']));
            $customer->setZipCode(rand('10000', '99999'));
            $customer->setCity($this->array_random(['Paris', 'Marseille', 'Toulouse', 'Lyon', 'Toulouse']));

            $manager->persist($customer);
            $manager->flush();
        }

        for ($j = 1; $j <= 3; ++$j) {
            $user = new User();
            $user->setEmail('user-' . $j . '@test.fr');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setFirstname($this->array_random(['John', 'Robert', 'Murielle', 'Alice', 'Maxime', 'Borice']));
            $user->setLastname($this->array_random(['Dulac', 'Wilson', 'Lopez', 'Mento', 'Durand', 'Jefferson']));
            $user->setCustomer($this->customerRepository->findOneBy(['name' => 'Customer ' . $j]));

            $manager->persist($user);
            $manager->flush();
        }

    }
}
