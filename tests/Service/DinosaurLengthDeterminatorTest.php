<?php

namespace Tests\Service;

use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DinosaurLengthDeterminatorTest extends KernelTestCase
{
    /**
     * @dataProvider getSpecificationTests
     *
     * @param $spec
     * @param $minExpectedSize
     * @param $maxExpectedSize
     */
    public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize)
    {
        $determinator = new DinosaurLengthDeterminator();
        $actualSize = $determinator->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
        $this->assertLessThanOrEqual($maxExpectedSize, $actualSize);
    }


    public function getSpecificationTests()
    {
        return [
            ['large carnivorous dinosaur', Dinosaur::LARGE, Dinosaur::HUGE-1],
            ['give me all the cookies!!!', 0, Dinosaur::LARGE-1],
            ['large herbivore',  Dinosaur::LARGE, Dinosaur::HUGE-1],
            ['huge dinosaur', Dinosaur::HUGE, 100],
            ['huge dino', Dinosaur::HUGE, 100],
            ['huge', Dinosaur::HUGE, 100],
            ['OMG', Dinosaur::HUGE, 100],
            ['😱', Dinosaur::HUGE, 100],
        ];
    }
}