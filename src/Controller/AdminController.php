<?php

namespace App\Controller;

use App\Entity\SPA;
use App\Form\SPAFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/create", name="admin_create_SPA")
     */
    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $spa = new SPA('');
        $form = $this->createForm(SPAFormType::class, $spa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spa);
            $entityManager->flush();
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/createSPA.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/spa_list", name="admin_SPA_list")
     */
    public function spaLIst()
    {
        return $this->render('admin/SPAlist.html.twig');
    }
}
