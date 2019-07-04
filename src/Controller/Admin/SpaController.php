<?php

namespace App\Controller\Admin;

use App\Command\Admin\CreateSPA;
use App\Command\Admin\DeleteSPA;
use App\Command\Admin\EditSPA;
use App\Entity\SPA;
use App\Entity\User;
use App\Form\CreateSPAForm;
use App\Form\DeleteSPAForm;
use App\Form\EditSPAForm;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/spa")
 * @IsGranted("ROLE_ADMIN")
 */

class SpaController extends AbstractController
{
    private $commandBus;
    private $entityManager;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list/{page}", defaults={"page" : "1"}, name="admin_SPA_list", methods={"GET"})
     */
    public function spaLIst($page)
    {

        $paginatedSpas = $this->entityManager->getRepository(SPA::class)->findAllPaginated($page);
        return $this->render('admin/SPAlist.html.twig',
            [
                'pagination' => $paginatedSpas
            ]);
    }

    /**
     * @Route("/{spa}/staff", defaults={"page" : "1"}, name="admin_spa_info", methods={"GET"})
     */
    public function spaInfo(SPA $spa, $page)
    {
        $paginatedUsers = $this->entityManager->getRepository(User::class)->findAllPaginated($page, $spa->getId());

        return $this->render('admin/SPAInfo.html.twig',
            [
                'pagination' => $paginatedUsers,
                'spa' => $spa
            ]);
    }

    /**
     * @Route("/create", name="admin_create_SPA",  methods={"GET","POST"})
     */
    public function create(Request $request)
    {
        $createSPA = new CreateSPA();
        $form = $this->createForm(CreateSPAForm::class, $createSPA);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createSPA);
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/createSPA.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{spa}", name="admin_edit_SPA", methods={"GET","POST"})
     */
    public function edit(SPA $spa, Request $request)
    {
        $editSPA = new EditSPA($spa);

        $form = $this->createForm(EditSPAForm::class, $editSPA);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editSPA);
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/editSPA.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{spa}", name="admin_delete_SPA", methods={"GET","DELETE"})
     */
    public function deleteSPA(SPA $spa, Request $request)
    {
        $deleteSPAForm = $this->createForm(DeleteSPAForm::class, $spa,
            [
                'action' => $this->generateUrl('admin_delete_SPA', ['spa' => $spa->getId()])
            ]);
        $deleteSPAForm->handleRequest($request);

        if ($deleteSPAForm->isSubmitted() && $deleteSPAForm->isValid()) {
            $deleteSPA = new DeleteSPA($spa);
            $this->commandBus->handle($deleteSPA);
            return $this->redirectToRoute('admin_SPA_list');
        }

        return $this->render('modal/SpaDeleteConfirmationModal.html.twig', [
            'deleteSPAForm' => $deleteSPAForm->createView(),
            'spa' => $spa
        ]);
    }
}
