<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @var Factory
     */
    private $faker;

    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager);
        $this->loadCustomer($manager);
    }

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function loadUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
            $user,
            'admin123456'
        ));
        $manager->persist($user);
        $manager->flush();
    }

    public function loadCustomer(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; ++$i) {
            $customer = new Customer();
            $customer->setEmail($this->faker->safeEmail);
            $customer->setCity($this->faker->city);
            $customer->setCompany($this->faker->company);
            $customer->setFirstName($this->faker->firstName);
            $customer->setLastName($this->faker->lastName);
            $customer->setPhone($this->faker->phoneNumber);
            $customer->setStreet($this->faker->streetAddress);
            $customer->setZip($this->faker->postcode);
            $customer->setUpdatedAt($this->faker->dateTimeThisYear);
            $customer->setCountry($this->faker->country);

            $manager->persist($customer);
        }
        $manager->flush();
    }
}
