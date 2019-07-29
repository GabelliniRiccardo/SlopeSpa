<?php


namespace App\Service;


use App\Entity\Operator;
use App\Entity\Treatment;
use App\Repository\OperatorRepository;
use App\Repository\TreatmentRepository;

class ReservationQueryService
{
    private $treatmentRepository;
    private $operatorRepository;

    public function __construct(TreatmentRepository $treatmentRepository, OperatorRepository $operatorRepository)
    {
        $this->treatmentRepository = $treatmentRepository;
        $this->operatorRepository = $operatorRepository;
    }

    public function findAvailableOperators(\DateTimeImmutable $startTime, ?\DateTimeImmutable $endTime, ?Treatment $treatment, ?int $reservationIdToIgnore)
    {
        if ($treatment) {
            return $this->operatorRepository->findAvailableOperatorsUsingTreatment($treatment->getId(), $startTime, $endTime, $reservationIdToIgnore);
        }
        return $this->operatorRepository->findAll();
    }

    public function findAvailableTreatments(\DateTimeImmutable $startTime, ?\DateTimeImmutable $endTime, ?Operator $operator, ?int $reservationIdToIgnore)
    {
        if ($operator && $endTime) {
            return $this->treatmentRepository->findAvailableTreatmentsUsingOperator($operator->getId(), $startTime, $endTime, $reservationIdToIgnore);
        } elseif ($operator && !$endTime) {
            return $operator->getTreatments();
        }
        return $this->treatmentRepository->findAll();
    }
}
