<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SampleController extends AbstractController
{
    private ProductService $service;

    public function __construct(ProductService $sampleService){
        $this->service = $sampleService;
    }

    #[Route('/sample', name: 'app_sample')]
    public function index(): Response
    {
        $this->service->exec();
        return $this->render('sample/index.html.twig', [
            'controller_name' => 'SampleController',
        ]);
    }
}
