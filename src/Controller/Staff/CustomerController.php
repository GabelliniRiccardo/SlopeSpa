<?php

namespace App\Controller\Staff;

use App\Command\Staff\Customer\CreateCustomer;
use App\Command\Staff\Customer\DeleteCustomer;
use App\Command\Staff\Customer\EditCustomer;
use App\Entity\Customer;
use App\Entity\SPA;
use App\Form\CreateCustomerForm;
use App\Form\DeleteCustomerForm;
use App\Form\EditCustomerForm;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/staff/customer")
 * @IsGranted("ROLE_STAFF")
 */
class CustomerController extends AbstractController
{
    private $commandBus;
    private $entityManager;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list/{page}", defaults={"page" : "1"}, name="staff_customer_list", methods={"GET"})
     */
    public function operatorList($page)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $paginatedOperators = $this->entityManager->getRepository(Customer::class)->findAllPaginated($page, $spa_id);

        return $this->render('staff/customer/customerList.html.twig',
            [
                'pagination' => $paginatedOperators,
            ]);
    }

    /**
     * @Route("/create", name="staff_create_customer",  methods={"GET","POST"})
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $spa = $this->entityManager->getRepository(SPA::class)->find($spa_id);

        $createCustomer = new CreateCustomer($spa);
        $form = $this->createForm(CreateCustomerForm::class, $createCustomer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createCustomer);
            $this->addFlash('success', 'Customer created');
            return $this->redirectToRoute('staff_customer_list');
        }

        return $this->render('staff/customer/createCustomer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{customer}", name="staff_edit_customer", methods={"GET","POST"})
     */
    public function edit(Customer $customer, Request $request)
    {
        $editCustomer = new EditCustomer($customer);

        $form = $this->createForm(EditCustomerForm::class, $editCustomer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editCustomer);
            $this->addFlash('success', 'Customer ' . $customer->getFirstName() . ' ' . $customer->getLastName() . ' updated');
            return $this->redirectToRoute('staff_customer_list');
        }
        return $this->render('staff/customer/editCustomer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{customer}", name="staff_delete_customer", methods={"GET","DELETE"})
     */
    public function delete(Customer $customer, Request $request)
    {
        $deleteCustomerForm = $this->createForm(DeleteCustomerForm::class, $customer,
            [
                'action' => $this->generateUrl('staff_delete_customer', ['customer' => $customer->getId()])
            ]);
        $deleteCustomerForm->handleRequest($request);

        if ($deleteCustomerForm->isSubmitted() && $deleteCustomerForm->isValid()) {
            $deleteSPA = new DeleteCustomer($customer);
            $this->commandBus->handle($deleteSPA);
            $this->addFlash('successDelete', 'Customer ' . $customer->getFirstName() . ' ' . $customer->getLastName() . ' deleted');
            return $this->redirectToRoute('staff_customer_list');
        }

        return $this->render('modal/CustomerDeleteConfirmationModal.html.twig', [
            'deleteCustomerForm' => $deleteCustomerForm->createView(),
            'customer' => $customer
        ]);
    }
}
