# entelisteam/php-dto-hydrator

Attribute-driven PHP DTO hydrator. Builds typed DTOs (and arrays of DTOs) from JSON-like data — scalars, enums, nested objects, union types, `DateTime`.

## Install

```bash
composer require entelisteam/php-dto-hydrator
```

Requires PHP 8.2 or newer. Depends on [`entelisteam/php-reflection-helpers`](https://packagist.org/packages/entelisteam/php-reflection-helpers).

## Quick start

Добавьте `HydratorTrait` в свой DTO — и получите статические методы для гидратации из массивов и объектов:

```php
use EntelisTeam\DTOHydrator\HydratorTrait;

class UserDTO {
    use HydratorTrait;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $email = null,
    ) {}
}

$user = UserDTO::hydrateObject([
    'id'    => '42',        // приведётся к int
    'name'  => 'Alice',
    'email' => 'a@b.com',
]);
```

Современные IDE подхватывают методы трейта автоматически — `implements HydratorInterface` имплементировать не нужно.

## Массив DTO

```php
$users = UserDTO::hydrateArray([
    ['id' => 1, 'name' => 'Alice'],
    ['id' => 2, 'name' => 'Bob'],
]);
```

Второй аргумент `hydrateArray($data, skipErrors: true)` пропускает невалидные элементы вместо того, чтобы кидать исключение на первой же ошибке.

## Вложенные объекты

Типы вложенных DTO определяются по `__construct` — никаких дополнительных атрибутов для них не нужно:

```php
class AddressDTO {
    use HydratorTrait;

    public function __construct(
        public readonly string $city,
        public readonly string $street,
    ) {}
}

class CustomerDTO {
    use HydratorTrait;

    public function __construct(
        public readonly int $id,
        public readonly AddressDTO $address,
    ) {}
}

$customer = CustomerDTO::hydrateObject([
    'id'      => 1,
    'address' => ['city' => 'Berlin', 'street' => 'Unter den Linden'],
]);
```

## Массивы DTO внутри DTO через `#[ArrayTypeOf]`

PHP-тип `array` не несёт информации об элементах — для типизированных коллекций используйте атрибут:

```php
use EntelisTeam\DTOHydrator\Attribute\ArrayTypeOf;

class LineItemDTO {
    use HydratorTrait;

    public function __construct(
        public readonly string $sku,
        public readonly int $qty,
    ) {}
}

class OrderDTO {
    use HydratorTrait;

    public function __construct(
        public readonly int $id,
        #[ArrayTypeOf('items', LineItemDTO::class)]
        public readonly array $items,
    ) {}
}

$order = OrderDTO::hydrateObject([
    'id'    => 100,
    'items' => [
        ['sku' => 'A-1', 'qty' => 2],
        ['sku' => 'B-7', 'qty' => 1],
    ],
]);
```

Каждый элемент `items` будет построен как `LineItemDTO`.

## Что умеет гидратор

- Скаляры с приведением типов (`"42"` → `int 42`).
- `enum` и `BackedEnum` — по значению.
- `DateTime` / `DateTimeImmutable` — из строки или таймстампа.
- Вложенные DTO и массивы DTO (через `#[ArrayTypeOf]`).
- Union-типы — выбирается первый совместимый по структуре вариант.
- Дефолтные значения из `__construct` — если поля нет во входных данных.

## Кэш гидраторов

`HydratorTrait::getHydrator()` отдаёт `Hydrator` из `HydratorRegistry` — на класс создаётся ровно один экземпляр за процесс, парсинг рефлексии не повторяется. Никакой ручной настройки не требуется.

## Исключения

Все ошибки гидратации наследуются от `EntelisTeam\DTOHydrator\Exception\HydrationException`:

- `RequiredArgumentException` — обязательное поле отсутствует во входных данных.
- `ArgumentTypeException` — значение нельзя привести к объявленному типу.

Оба исключения несут JSON-путь до проблемного поля, чтобы сообщение об ошибке сразу указывало место.

## License

MIT.
