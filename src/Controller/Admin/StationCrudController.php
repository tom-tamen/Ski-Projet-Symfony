<?php

namespace App\Controller\Admin;

use App\Entity\Station;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Station::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex(),
            AssociationField::new('domain'),
            AssociationField::new('owner'),
            TextField::new('name'),
            TextField::new('description'),
            ImageField::new('ImageURL')
                ->setUploadDir('public/assets/images/stations')
                ->setBasePath('assets/images/stations')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
        ];
    }

}
