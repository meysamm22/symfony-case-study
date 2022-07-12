<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


class SampleController extends AbstractController
{
    private ProductService $service;

    public function __construct(ProductService $sampleService){
        $this->service = $sampleService;
    }

    /**
     * @throws \Symfony\Component\Cache\Exception\CacheException
     * @throws \ErrorException
     */
    #[Route('/sample', name: 'app_sample')]
    public function index(): Response
    {

        $this->service->exec();
        return $this->render('sample/index.html.twig', [
            'controller_name' => 'SampleController',
        ]);
    }

    #[Route('/fetch', name: 'fetch')]
    public function fetch(CacheInterface $customThingCache): Response
    {

        $data = $customThingCache->getItem("product");
        if (!$data->isHit())
        {
            $data->set($this->service->fetch())->tag('product')->expiresAfter(600);
            $customThingCache->save($data);
        }

        foreach ($data->get() as $product)
        {
            echo $product->calcName(). '<br>';
        }

    }
}
