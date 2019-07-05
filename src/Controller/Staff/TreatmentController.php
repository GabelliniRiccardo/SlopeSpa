<?php

namespace App\Controller\Staff;

use App\Command\Staff\Treatment\CreateTreatment;
use App\Command\Staff\Treatment\DeleteTreatment;
use App\Command\Staff\Treatment\EditTreatment;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Form\CreateTreatmentForm;
use App\Form\DeleteTreatmentForm;
use App\Form\EditTreatmentForm;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/staff/treatment")
 * @IsGranted("ROLE_STAFF")
 */
class TreatmentController extends AbstractController
{
    private $commandBus;
    private $entityManager;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list/{page}", defaults={"page" : "1"}, name="staff_treatment_list", methods={"GET"})
     */
    public function treatmentList($page)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $paginatedtreatments = $this->entityManager->getRepository(Treatment::class)->findAllPaginated($page, $spa_id);

        return $this->render('staff/treatment/treatmentList.html.twig',
            [
                'pagination' => $paginatedtreatments,
            ]);
    }

    /**
     * @Route("/create", name="staff_create_treatment",  methods={"GET","POST"})
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $spa = $this->entityManager->getRepository(SPA::class)->find($spa_id);

        $createTreatment = new CreateTreatment($spa);
        $form = $this->createForm(CreateTreatmentForm::class, $createTreatment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createTreatment);
            return $this->redirectToRoute('staff_dashboard');
        }
        return $this->render('staff/treatment/createTreatment.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{treatment}", name="staff_edit_treatment", methods={"GET","POST"})
     */
    public function edit(Treatment $treatment, Request $request)
    {
        $editTreatment = new EditTreatment($treatment);

        $form = $this->createForm(EditTreatmentForm::class, $editTreatment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editTreatment);
            return $this->redirectToRoute('staff_dashboard');
        }
        return $this->render('staff/treatment/editTreatment.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{treatment}", name="staff_delete_treatment", methods={"GET","DELETE"})
     */
    public function deleteTreatment(Treatment $treatment, Request $request)
    {
        $deleteTreatmentForm = $this->createForm(DeleteTreatmentForm::class, $treatment,
            [
                'action' => $this->generateUrl('staff_delete_treatment', ['treatment' => $treatment->getId()])
            ]);
        $deleteTreatmentForm->handleRequest($request);

        if ($deleteTreatmentForm->isSubmitted() && $deleteTreatmentForm->isValid()) {
            $deleteTreatment = new DeleteTreatment($treatment);
            $this->commandBus->handle($deleteTreatment);
            return $this->redirectToRoute('staff_dashboard');
        }

        return $this->render('modal/TreatmentDeleteConfirmationModal.html.twig', [
            'deleteTreatmentForm' => $deleteTreatmentForm->createView(),
            'treatment' => $treatment
        ]);
    }
}
