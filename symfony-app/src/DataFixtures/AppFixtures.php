<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Provider;
use App\Entity\ProviderType;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadProviderTypes($manager);
        $this->loadProviders($manager);
    }

    private function loadProviderTypes(ObjectManager $manager): void
    {
        foreach ($this->getProviderTypes() as $providerTypeName) {
            $providerType = new ProviderType();
            $providerType->setName($providerTypeName);
            $manager->persist($providerType);
        }

        $manager->flush();
    }

    private function loadProviders(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $providerTypes = $manager->getRepository(ProviderType::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $provider = new Provider();
            $provider->setName($faker->company);
            $provider->setEmail($faker->email);
            $provider->setPhone($faker->phoneNumber);
            $provider->setActive($faker->boolean);

            $randomProviderType = $faker->randomElement($providerTypes);
            $provider->setProviderType($randomProviderType);

            $manager->persist($provider);
        }

        $manager->flush();
    }

    private function getProviderTypes(): array
    {
        return [
            'Hotel',
            'Pista',
            'Complemento',
        ];
    }
}
