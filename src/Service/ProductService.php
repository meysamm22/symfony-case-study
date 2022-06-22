<?php


namespace App\Service;


use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductService
{

    private ProductRepository $repository;
    private ValidatorInterface $validator;
    private CategoryRepository $categoryRepository;

    public function __construct(ProductRepository $repository,CategoryRepository $categoryRepository, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->categoryRepository = $categoryRepository;
    }

    public function exec(){
        $category = new Category();
        $category->setName("Lap Top");

        $product = new Product("Lenovo NT1", 1);
        $product->setCategory($category);
        $this->categoryRepository->add($category);
        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {

        }
        $this->repository->add($product, true);

    }

}