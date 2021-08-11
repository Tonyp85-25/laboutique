<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{TextField,TextEditorField,ImageField};

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title',"Titre de l'en-tête" ),
            TextEditorField::new('content',"Contenu"),
            TextField::new('btnTitle','Titre du bouton'),
            TextField::new('btnUrl','Url de notre bouton'),
            ImageField::new('illustration')->setBasePath('/uploads')->setUploadDir('public/uploads')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),

        ];
    }
    
}
