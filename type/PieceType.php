<?php

namespace stp\spsr\type;

use stp\spsr\BaseType;

/**
 * @property int|null $PieceID Штрихкод вложимого из диапазона, выделенного ООО "СПСР-Экспресс", начинается с "20"
 * @property string|null $ClientBarcode Уникальный ШК вложимого, присвоенный отправителем
 * @property int $Description Описание вложимого в виде цифрового кода. Виды вложимого, допустимые для сервисов см. self::TYPE_*
 * @property float $Weight Вес вложимого в кг
 * @property float $Length Длина вложимого в см
 * @property float $Width Ширина вложимого в см
 * @property float $Depth Высота вложимого в см
 */
class PieceType extends BaseType
{
    /**
     * Документы и печатная продукция
     */
    const TYPE_DOC = 15;

    /**
     * Товары народного потребления (без техники)
     */
    const TYPE_FMCG = 16;

    /**
     * Техника и электроника без ГСМ (единичное количество)
     */
    const TYPE_ELECTRONICS = 17;

    /**
     * Драгоценности
     */
    const TYPE_JEWELRY = 18;

    /**
     * Медикаменты и БАДы
     */
    const TYPE_MEDICINES = 19;

    /**
     * Косметика и парфюмерия
     */
    const TYPE_COSMETICS = 20;

    /**
     * продукты питания (партия)
     */
    const TYPE_FOODSTUFFS = 21;

    /**
     * Техника и электроника c ГСМ (партия)
     */
    const TYPE_ELECTRONICS_LOT = 22;

    /**
     * опасные грузы
     */
    const TYPE_DANGEROUS_GOODS = 23;

    /**
     * товары народного потребления (без техники, партия)"
     */
    const TYPE_FMCG_LOT = 24;

}
