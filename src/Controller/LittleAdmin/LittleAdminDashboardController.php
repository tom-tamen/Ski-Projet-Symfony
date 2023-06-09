<?php

namespace App\Controller\LittleAdmin;

use App\Controller\LittleAdmin\StationCrudController;
use App\Entity\Faq;
use App\Entity\Lift;
use App\Entity\Slope;
use App\Entity\Station;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LittleAdminDashboardController extends AbstractDashboardController
{
    #[Route('/myadmin', name: 'myadmin')]
    public function index(): Response
    {
        

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(StationCrudController::class)->generateUrl());

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
        yield MenuItem::linkToCrud('Station', 'fas fa-list', Station::class);
        yield MenuItem::linkToCrud('Slope', 'fas fa-list', Slope::class);
        yield MenuItem::linkToCrud('Lift', 'fas fa-list', Lift::class);
        yield MenuItem::linkToCrud('FAQ', 'fas fa-list', Faq::class);
    }
}
