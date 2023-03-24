<?php

namespace App\Controller\Admin;

use App\Entity\Lift;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LiftCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lift::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
