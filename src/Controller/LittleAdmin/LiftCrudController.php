<?php

namespace App\Controller\LittleAdmin;

use App\Entity\Lift;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class LiftCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Lift::class;
    }
    
    
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): \Doctrine\ORM\QueryBuilder
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('entity')
            ->from(Lift::class, 'entity')
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
            ChoiceField::new('type')->setChoices([
                "Tapis roulant"=>"Tapis roulant",
                "Tire-fesses"=>"Tire-fesses",
                "Les télésièges"=>"Les télésièges",
                'Les télécabines'=>'Les télécabines',
                'Les téléphériques'=>'Les téléphériques',
                'Les funiculaires'=>'Les funiculaires',
            ]),
            TimeField::new('open'),
            TimeField::new('close'),
            TextField::new('description'),
            TimeField::new('duration'),
            ChoiceField::new('grade')->setChoices([
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ]),


        ];
    }
}