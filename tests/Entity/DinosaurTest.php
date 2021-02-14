<?php

namespace Tests\Entity;

use AppBundle\Entity\Dinosaur;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DinosaurTest extends WebTestCase
{
    public function testSettingLength()
    {
        $dino = new Dinosaur();
        $this->assertSame(0, $dino->getLength());

        $dino->setLength(9);
        $this->assertSame(9, $dino->getLength());
    }

    public function testDinoHasNotShrunk()
    {
        $dino = new Dinosaur();
        $dino->setLength(15);
        $this->assertGreaterThan(12, $dino->getLength());
    }

    public function testReturnFullSpecificationOfDino()
    {
        $dino = new Dinosaur();

        $this->assertSame(
            'The unknown non-carnivorous dinosaur is 0 meters long',
            $dino->getSpecification()
        );
    }

    public function testReturnFullSpecificationOfTyrannosaurus()
    {
        $dino = new Dinosaur('Tyrannosaurus', true);
        $dino->setLength(12);

        $this->assertSame(
            'The Tyrannosaurus carnivorous dinosaur is 12 meters long',
            $dino->getSpecification()
        );
    }
}