<?php

namespace App\Controller\Admin;

use App\Entity\ReservationItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use PhpParser\Node\Expr\Yield_;

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
