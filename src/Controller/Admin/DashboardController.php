<?php

namespace App\Controller\Admin;

use App\Entity\Challenge;
use App\Entity\Domain;
use App\Entity\Faq;
use App\Entity\Lift;
use App\Entity\Slope;
use App\Entity\Station;
use App\Entity\User;
use App\Controller\Admin\StationCrudController;
use App\Controller\Admin\SlopeCrudController;
use App\Controller\Admin\LiftCrudController;
use App\Controller\Admin\FaqCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(DomainCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ski Projet Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Domains', 'fa fa-home', Domain::class);
        yield MenuItem::linkToCrud('Stations','fas fa-list', Station::class)->setController(StationCrudController::class);
        yield MenuItem::linkToCrud('Slope','fa-solid fa-person-skiing', Slope::class)->setController(SlopeCrudController::class);
        yield MenuItem::linkToCrud('Lift','fa-solid fa-cable-car', Lift::class)->setController(LiftCrudController::class);
        yield MenuItem::linkToCrud('User','fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('F.A.Q','fa-solid fa-question', Faq::class)->setController(FaqCrudController::class);
        yield MenuItem::linkToCrud('Challenge','fa-solid fa-medal', Challenge::class);
    }
}