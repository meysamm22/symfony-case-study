<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type:"string")]
#[ORM\DiscriminatorMap(["product" => "Product", "laptop" => "Laptop", "desk" => "Desk"])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
abstract class Product
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    private $name;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    private $category;

    #[ORM\ManyToMany(targetEntity: Invoice::class, inversedBy: 'products')]
    private $invoices;

    // ...
    /**
     * Product constructor.
     * @param $name
     * @param $type
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->invoices = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        $this->invoices->removeElement($invoice);

        return $this;
    }

    protected abstract function calcName();

}
