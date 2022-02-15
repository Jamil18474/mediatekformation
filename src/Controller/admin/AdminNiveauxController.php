<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NiveauRepository;
use App\Entity\Niveau;

/**
 * Description of AdminNiveauxController
 *
 * @author Jamil
 */
class AdminNiveauxController extends AbstractController {
    
    /**
     *
     * @var NiveauRepository
     */
    private $repository;
    
    /**
     * 
     * @var EntityManagerInterface
     */
    private $om;
            
    /**
     * 
     * @param NiveauRepository $repository
     * @param EntityManagerInterface $om
     */
    function __construct(NiveauRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }

    /**
     * @Route("/admin/niveaux", name="admin.niveaux")
     * @return Response
     */
    public function index(): Response{
        $niveaux = $this->repository->findAll();
        return $this->render("admin/admin.niveaux.html.twig", [
            'niveaux' => $niveaux 
        ]);
    }
    
    /**
     * @Route("/admin/niveau/suppr/{id}", name="admin.niveau.suppr")
     * @param Niveau $niveau
     * @return Response
     */
    public function suppr(Niveau $niveau) : Response{
        $this->om->remove($niveau);
        $this->om->flush();
        return $this->redirectToRoute('admin.niveaux');
    }
    
    /**
     * @Route("/admin/niveau/ajout}", name="admin.niveau.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request) : Response{
        $libelleNiveau=$request->get("nom");
        $niveau = new Niveau();
        $niveau->setLibelle($libelleNiveau);
        $this->om->persist($niveau);
        $this->om->flush();
        return $this->redirectToRoute('admin.niveaux');
    }
}
