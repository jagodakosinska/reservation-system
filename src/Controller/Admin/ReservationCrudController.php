<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideWhenCreating()
            ->setDisabled();
        yield AssociationField::new('schedule');
        yield ChoiceField::new('status')
            ->allowMultipleChoices(false)
            ->renderExpanded(true)
            ->setChoices([
                'Reservation is paid' => Reservation::PAID,
                'Reservation is made' => Reservation::RESERVED,
            ])
            ->setFormTypeOption('data', Reservation::RESERVED);
//        yield DateTimeField::new('validDate');
        yield CollectionField::new('reservationItems')
            ->renderExpanded()
            ->useEntryCrudForm(ReservationItemCrudController::class);
        yield NumberField::new('totalPrice')->onlyOnIndex();
        yield DateTimeField::new('validDate')->onlyOnIndex();
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, 'detail');

    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->getRepository(Reservation::class)->prepareData($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);

    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->getRepository(Reservation::class)->prepareData($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }


}
