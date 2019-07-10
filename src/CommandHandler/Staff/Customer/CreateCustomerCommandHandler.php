<?php


namespace App\CommandHandler\Staff\Customer;


use App\Command\Staff\Customer\CreateCustomer;
use App\Service\DomainManager\CustomerManager;

class CreateCustomerCommandHandler
{
    protected $customerManager;

    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    public function handle(CreateCustomer $command): void
    {
        $this->customerManager->create($command->customerDTO);
    }
}
