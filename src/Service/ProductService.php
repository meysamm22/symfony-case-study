<?php


namespace App\Service;


use App\Entity\Category;
use App\Entity\Desk;
use App\Entity\Laptop;
use App\Entity\Product;
use App\Events\ProductCreatedEvent;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Subscribers\ProductSubscriber;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductService
{

    private ProductRepository $repository;
    private ValidatorInterface $validator;
    private CategoryRepository $categoryRepository;
    private LoggerInterface $logger;

    public function __construct(
        ProductRepository $repository,
        CategoryRepository $categoryRepository,
        ValidatorInterface $validator,
        LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    public function exec(){

        $category = new Category();
        $category->setName("Lap Top");

        $product = new Desk("Lenovo NT1");
        $product->setCategory($category);
        $product->setWidth("2 Meter");
        $this->categoryRepository->add($category);
        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {

        }
        $this->repository->add($product, true);
        $this->logger->info("product is created");

        $createdEvent = new ProductCreatedEvent($product);
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new ProductSubscriber($this->logger));
        $dispatcher->dispatch($createdEvent, ProductCreatedEvent::NAME);

    }

    public function fetch(): array{
        return $this->repository->findAll();
    }

}