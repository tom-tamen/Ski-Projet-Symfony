<?php

namespace App\Controller\LittleAdmin;

use App\Entity\Station;
use App\Repository\DomainRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use Symfony\Component\Validator\Constraints\NotBlank;

class StationCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Station::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('entity')
            ->from(Station::class, 'entity')
            ->andWhere('entity.owner = :user')
            ->setParameter('user', $this->getUser());

        return $qb;
    }
    public function configureFields(string $pageName): iterable
    {
        return[AssociationField::new('domain')
        ->setFormTypeOptions([
            'query_builder' => function (DomainRepository $repository) {
                return $repository->createQueryBuilder('d')
                    ->orderBy('d.name', 'ASC');
            },
        ]),

    AssociationField::new('owner')
        ->setFormTypeOptions([
            'query_builder' => function (UserRepository $repository) {
                return $repository->createQueryBuilder('u')
                    ->where('u.id = :userId')
                    ->setParameter('userId', $this->getUser());
            },
        ]),

    TextField::new('name'),
    ImageField::new('img_url')->setUploadDir('public/uploads/stations')
        ->setBasePath('uploads/products')
        ->setUploadedFileNamePattern('[slug]-[randomhash].[extension]')
        ->setFormTypeOption('constraints', [new NotBlank()]),
    TextField::new('description'),];
        
    }
}
