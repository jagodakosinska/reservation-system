<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

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
                    'Reservation is paid' => 'paid',
                    'Reservation is made' => 'reserved',
                    'Reservation is canceled' => 'canceled',
            ]);
    }

}
