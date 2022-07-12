<?php


namespace App\Events;


use App\Entity\Product;
use Symfony\Contracts\EventDispatcher\Event;

class ProductCreatedEvent extends Event
{
    public const NAME = "product.created";

    private Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

}