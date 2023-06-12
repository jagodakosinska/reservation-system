<?php

namespace App\Controller\Admin;

use App\Entity\Price;
use App\Entity\Reservation;
use App\Entity\Schedule;
use App\Entity\Screen;
use App\Entity\Seat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Reservation System');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Screens', 'fa-solid fa-film', Screen::class);
        yield MenuItem::linkToCrud('Seat', 'fa-solid fa-chair', Seat::class);
        yield MenuItem::linkToCrud('Schedule', 'fa-solid fa-clapperboard', Schedule::class);
        yield MenuItem::linkToCrud('Reservation', 'fa-solid fa-square-poll-vertical', Reservation::class);
        yield MenuItem::linkToCrud('Price', 'fa-regular fa-money-bill-1', Price::class);
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->showEntityActionsInlined();

    }


}
