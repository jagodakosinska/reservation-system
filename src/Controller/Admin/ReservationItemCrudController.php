<?php

namespace App\Controller\Admin;

use App\Entity\ReservationItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ReservationItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReservationItem::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('seat');
        yield AssociationField::new('price');
    }

}
