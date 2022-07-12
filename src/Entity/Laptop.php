<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Laptop extends Product
{
    public function __construct($name)
    {
        parent::__construct($name);
    }

    #[ORM\Column(type: 'string', length: 255)]
    private $cpu;

    public function getCpu(): ?string
    {
        return $this->cpu;
    }

    public function setCpu(string $cpu): self
    {
        $this->cpu = $cpu;

        return $this;
    }


    public function calcName()
    {
        return $this->getName() . '-'.$this->getCpu();
    }
}
