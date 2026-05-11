<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Attribute;

use Attribute;

/**
 * Атрибут для указания источника данных.
 *  Первый аргумент - поле из данных которое нужно взять для заполнения указанного значения
 *  Второй (опциональный) - источник данных (souce = null - маппинг применяется всегда, source=значение - маппинг применяется только для указанного источника)
 *  Источник явно передается в гидратор при вызове (если используется совместно с lbaf - есть ряд пресетов используемых на уровне lbaf)
 *
 * Примеры:
 *
 * class User {
 *      #[Map('user_id', 'old_json)]
 *      public int $userId;
 *
 *      function __construct(
 *          #[Map('name')] $userName
 *      ) {
 *          ...
 *      }
 *

 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
class Map
{

    public function __construct(public string $field, public ?string $source = null)
    {

    }
}
