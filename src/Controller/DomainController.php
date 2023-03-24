<?php

namespace App\Controller;

use App\Repository\DomainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DomainController extends AbstractController
{
    #[Route('/domain/{id}', name: 'domain_show')]
    public function index($id, DomainRepository $domainRepository): Response
    {
        $domain = $domainRepository->find($id);
        if(!$domain) {
            throw $this->createNotFoundException('Domain not found');
        }
        return $this->render('domain/index.html.twig', [
            'domain' => $domain
        ]);
    }
}
