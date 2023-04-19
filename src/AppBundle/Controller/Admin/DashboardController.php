<?php

namespace App\AppBundle\Controller\Admin;

use App\AppBundle\Entity\Log;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EasyAdmin
 * @see https://symfonycasts.com/screencast/easyadminbundle
 * @see https://symfony.com/bundles/EasyAdminBundle/current/index.html
 */
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    /** @see https://symfony.com/bundles/EasyAdminBundle/current/dashboards.html */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Application')
        ;
    }

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Log', 'fas fa-list', Log::class);
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToUrl('Visit public website', null, '/');
    }
}
