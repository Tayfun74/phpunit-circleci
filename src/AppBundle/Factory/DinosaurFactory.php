<?php


namespace AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{
    /**
     * @var DinosaurLengthDeterminator
     */
    protected $determinator;

    public function __construct(DinosaurLengthDeterminator $determinator)
    {
        $this->determinator = $determinator;
    }

    public function growVelociraptor(int $length)
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    private function createDinosaur(string $genus, bool $isCar, int $length)
    {
        $dino =  new Dinosaur($genus, $isCar);
        $dino->setLength($length);
        return $dino;
    }

    public function growFromSpecification(string $specification)
    {
        $codeName = 'InG-' . random_int(1, 99999);
        $isCarnivorous = false;
        $length = $this->determinator->getLengthFromSpecification($specification);

        if (stripos($specification, 'carnivorous') !== false)
        {
            $isCarnivorous = true;
        }

        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }
}