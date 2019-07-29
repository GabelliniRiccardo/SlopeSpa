<?php


namespace App\DataFixtures\SingleEntityFixture;


use App\Entity\Operator;
use App\Entity\SPA;
use App\Entity\Treatment;
use App\Objects\Money;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use \Symfony\Component\Config\Definition\Exception\Exception;

class TreatmentCreator
{

    /**
     * @param ObjectManager $manager
     * @param mixed[] $fields
     * @return Treatment
     */
    public static function create(ObjectManager $manager, array $fields = []): Treatment
    {
        $spa = $manager->getRepository(SPA::class)->find($fields['spa_id']);
        if (is_null($spa)) {
            throw new Exception('Spa with id: ' . $fields['spa_id'] . ' not found');
        }

        $money = new Money($fields['price'] ?? 100, 'EURO');

        $treatment = new Treatment(
            $fields['name'] ?? 'name not found',
            $money,
            $fields['duration'] ?? 'duration not found',
            $fields['VAT'] ?? 22,
            $spa
        );

        $operatorsIds = $fields['operators_id'];
        foreach ($operatorsIds as $operatorId){
            $operator = $manager->getRepository(Operator::class)->find($operatorId);
            $treatment->addOperator($operator);
        }

        $manager->persist($treatment);

        return $treatment;
    }
}
