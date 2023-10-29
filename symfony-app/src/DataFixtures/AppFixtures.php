<?php

namespace App\DataFixtures;

use App\Entity\ProviderType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadProviderTypes($manager);
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

    private function getProviderTypes(): array
    {
        return [
            'Hotel',
            'Pista',
            'Complemento',
        ];
    }
}
