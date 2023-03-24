<?php

namespace App\Controller\Admin;

use App\Entity\Slope;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SlopeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slope::class;
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
