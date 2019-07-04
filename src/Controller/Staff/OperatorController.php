<?php

namespace App\Controller\Staff;

use App\Command\Staff\Operator\CreateOperator;
use App\Entity\Operator;
use App\Entity\SPA;
use App\Form\CreateOperatorForm;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/staff/operator")
 * @IsGranted("ROLE_STAFF")
 */
class OperatorController extends AbstractController
{
    private $commandBus;
    private $entityManager;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list/{page}", defaults={"page" : "1"}, name="staff_operator_list", methods={"GET"})
     */
    public function operatorList($page)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $paginatedOperators = $this->entityManager->getRepository(Operator::class)->findAllPaginated($page, $spa_id);

        return $this->render('staff/operator/operatorList.html.twig',
            [
                'pagination' => $paginatedOperators,
            ]);
    }

    /**
     * @Route("/create", name="staff_create_operator",  methods={"GET","POST"})
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $spa = $this->entityManager->getRepository(SPA::class)->find($spa_id);
        $treatmentList = $spa->getTreatments();

        $createOperator = new CreateOperator($spa);
        $form = $this->createForm(CreateOperatorForm::class, $createOperator, array('treatments' => $treatmentList ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createOperator);
            return $this->redirectToRoute('staff_dashboard');
        }

        return $this->render('staff/operator/createOperator.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
