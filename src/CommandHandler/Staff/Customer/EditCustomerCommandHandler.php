<?php


namespace App\CommandHandler\Staff\Customer;


use App\Command\Staff\Customer\EditCustomer;
use App\Service\DomainManager\CustomerManager;

class EditCustomerCommandHandler
{
    protected $customerManager;

    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    public function handle(EditCustomer $command): void
    {
        $this->customerManager->update($command->customerDTO);
    }
}
