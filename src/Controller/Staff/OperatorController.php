<?php

namespace App\Controller\Staff;

use App\Command\Staff\Operator\CreateOperator;
use App\Command\Staff\Operator\DeleteOperator;
use App\Command\Staff\Operator\EditOperator;
use App\Entity\Operator;
use App\Entity\SPA;
use App\Form\CreateOperatorForm;
use App\Form\DeleteOperatorForm;
use App\Form\EditOperatorForm;
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
        $form = $this->createForm(CreateOperatorForm::class, $createOperator, array('treatments' => $treatmentList));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createOperator);
            return $this->redirectToRoute('staff_operator_list');
        }

        return $this->render('staff/operator/createOperator.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{operator}", name="staff_edit_operator", methods={"GET","POST"})
     */
    public function edit(Operator $operator, Request $request)
    {
        $editOperator = new EditOperator($operator);
        $treatmentList = $operator->getSpa()->getTreatments();

        $form = $this->createForm(EditOperatorForm::class, $editOperator, array('treatments' => $treatmentList));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editOperator);
            return $this->redirectToRoute('staff_operator_list');
        }
        return $this->render('staff/operator/editOperator.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{operator}", name="staff_delete_operator", methods={"GET","DELETE"})
     */
    public function deleteSPA(Operator $operator, Request $request)
    {
        $deleteOperatorForm = $this->createForm(DeleteOperatorForm::class, $operator,
            [
                'action' => $this->generateUrl('staff_delete_operator', ['operator' => $operator->getId()])
            ]);
        $deleteOperatorForm->handleRequest($request);

        if ($deleteOperatorForm->isSubmitted() && $deleteOperatorForm->isValid()) {
            $deleteSPA = new DeleteOperator($operator);
            $this->commandBus->handle($deleteSPA);
            return $this->redirectToRoute('staff_operator_list');
        }

        return $this->render('modal/OperatorDeleteConfirmationModal.html.twig', [
            'deleteOperatorForm' => $deleteOperatorForm->createView(),
            'operator' => $operator
        ]);
    }
}
