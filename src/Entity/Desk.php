<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Desk extends Product
{
    public function __construct($name)
    {
        parent::__construct($name);
    }

    #[ORM\Column(type: 'string', length: 255)]
    private $width;

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function calcName()
    {
        return $this->getName() . '-'.$this->getWidth();
    }

}
