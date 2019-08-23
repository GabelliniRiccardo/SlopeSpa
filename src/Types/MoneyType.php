<?php


namespace App\Types;


use App\Objects\Money;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Money datatype.
 */
class MoneyType extends Type
{
    const MONEY_TYPE = 'money_type';

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'float';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Money|mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Money($value, 'EUR');
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return float|mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Money) {
            $value = $value->getValue();
        }
        return $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::MONEY_TYPE;
    }
}
