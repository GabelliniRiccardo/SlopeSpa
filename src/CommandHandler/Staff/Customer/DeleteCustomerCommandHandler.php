<?php


namespace App\CommandHandler\Staff\Customer;


use App\Command\Staff\Customer\DeleteCustomer;
use App\Service\DomainManager\CustomerManager;

class DeleteCustomerCommandHandler
{
    protected $customerManager;

    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    public function handle(DeleteCustomer $command): void
    {
        $this->customerManager->delete($command->customer);
    }
}
