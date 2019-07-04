<?php

namespace App\Controller\Staff;

use App\Command\Staff\Treatment\CreateTreatment;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Form\CreateTreatmentForm;
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
}
