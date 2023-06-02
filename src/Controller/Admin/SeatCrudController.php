<?php

namespace App\Controller\Admin;


use App\Entity\Seat;
use App\Message\GenerateSeatsMessage;
use App\MessageHandler\GenerateSeatsMessageHandler;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Messenger\MessageBusInterface;

class SeatCrudController extends AbstractCrudController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator, private MessageBusInterface $bus)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Seat::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        $generate = Action::new('generate')
            ->linkToCrudAction('generate')
            ->createAsGlobalAction()
            ->setIcon('fa fa-star');


        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, $generate);

    }

    public function generate(AdminContext $context)
    {
        $msg = new GenerateSeatsMessage();
        $this->bus->dispatch($msg);
        $this->addFlash('success', 'Generation in progress');
        $url = $this->adminUrlGenerator
            ->setController(self::class)
            ->setAction(Crud::PAGE_INDEX);
        return $this->redirect($url);
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('screen');
        yield IntegerField::new('number');
    }

}
