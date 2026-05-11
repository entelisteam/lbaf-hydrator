<?php
declare(strict_types=1);

namespace EntelisTeam\DTOHydrator\Attribute;

use Attribute;

/**
 * Атрибут для указания типа элементов массива.
 *
 * Примеры:
 *
 * 1. Указываем тип элементов для параметра
 *    function process (#[ArrayTypeOf(User::class)] array $users)
 *
 * 2. Указываем тип элементов для свойства
 *    #[ArrayTypeOf(Product::class)]
 *    private array $products;
 *
 * 3. Указываем параметр и тип явно
 *    #[ArrayTypeOf('items', Item::class)]
 *    function handle (array $items)
 *
 * 4. Поддержка union типов
 *    #[ArrayTypeOf([User::class, Admin::class])]
 *    function process (array $entities)
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ArrayTypeOf
{
    /**
     * @var string|string[]
     */
    public string|array $targetClass;
    public ?string $param = null;

    public function __construct(string|array $paramOrTargetClass, string|array|null $targetClass = null)
    {
        if (is_null($targetClass)) {
            $this->targetClass = $paramOrTargetClass;
            $this->param = null;
        } else {
            $this->targetClass = $targetClass;
            $this->param = $paramOrTargetClass;
        }
    }
}
