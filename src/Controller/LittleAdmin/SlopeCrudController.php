<?php

namespace App\Controller\LittleAdmin;

use App\Entity\Slope;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class SlopeCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Slope::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): \Doctrine\ORM\QueryBuilder
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('entity')
            ->from(Slope::class, 'entity')
            ->innerJoin('entity.station', 'station')
            ->andWhere('station.owner = :user')
            ->setParameter('user', $this->getUser());

        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('station')->autocomplete(),
            TextField::new('name'),
            ChoiceField::new('difficulty')->setChoices([
                'Verte' => 'Verte',
                'Bleu' => 'Bleu',
                'Rouge' => 'Rouge',
                'Noir' => 'Noir',
                'Double Noir' => 'Double Noir',
            ]),
            BooleanField::new('is_open'),
            TextField::new('description'),
            ChoiceField::new('type')->setChoices([
                'Alpines'=>'Alpines',
                'Nordiques'=>'Nordiques',
            ]),
            ChoiceField::new('grade')->setChoices([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ]),
            TimeField::new('duration'),
            IntegerField::new('people'),
            ChoiceField::new('quality')->setChoices([
                'Mauvais état' => 'Mauvais état',
                'Etat moyen' => 'Etat moyen',
                'Bon état' => 'Bon état',
            ]),



        ];
    }
}