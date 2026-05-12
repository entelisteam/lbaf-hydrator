# entelisteam/lbaf-hydrator

Attribute-driven PHP DTO hydrator. Builds typed DTOs (and arrays of DTOs) from JSON-like data — scalars, enums, nested objects, union types, `DateTime`.

## Install

```bash
composer require entelisteam/php-dto-hydrator
```

Requires PHP 8.2 or newer. Depends on [`entelisteam/php-reflection-helpers`](https://packagist.org/packages/entelisteam/php-reflection-helpers).

## Quick start

Добавьте `HydratorTrait` в свой DTO — и получите статические методы для гидратации из массивов и объектов:

```php
use EntelisTeam\Lbaf\Hydrator\HydratorTrait;

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
use EntelisTeam\Lbaf\Hydrator\Attribute\ArrayTypeOf;

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

## Переименование полей через `#[Map]`

Когда имя свойства DTO отличается от ключа во входных данных (snake_case → camelCase, legacy-схемы, чужие API), используйте `#[Map(<имя поля во входных данных>)]`:

```php
use EntelisTeam\Lbaf\Hydrator\Attribute\Map;

class UserDTO {
    use HydratorTrait;

    #[Map('user_id')]
    public readonly int $userId;

    #[Map('full_name')]
    public readonly string $fullName;
}

$user = UserDTO::hydrateObject([
    'user_id'   => 42,
    'full_name' => 'Alice Doe',
]);
```

Атрибут работает и на параметрах конструктора (в том числе promoted):

```php
class CustomerDTO {
    use HydratorTrait;

    public function __construct(
        #[Map('customer_id')]   public readonly int $id,
        #[Map('shipping_city')] public readonly string $city,
    ) {}
}
```

Если ключа из `#[Map]` нет во входных данных — поле получит значение по умолчанию (или будет выброшен `RequiredArgumentException`, если default отсутствует и тип не nullable). Путь в сообщении ошибки имеет вид `propName{mappedKey}`, чтобы было видно и имя свойства, и имя ключа.

### Несколько источников данных

Если один и тот же DTO собирается из разных схем (например, legacy- и новый API), можно навесить несколько `#[Map]` с разными `source` и передать нужный источник в гидратор:

```php
class UserDTO {
    use HydratorTrait;

    #[Map('user_id', 'legacy')]
    #[Map('id', 'v2')]
    public readonly int $userId;

    #[Map('full_name', 'legacy')]
    #[Map('name', 'v2')]
    public readonly string $fullName;
}

$fromLegacy = UserDTO::hydrateObject(
    ['user_id' => 42, 'full_name' => 'Alice Doe'],
    source: 'legacy',
);

$fromV2 = UserDTO::hydrateObject(
    ['id' => 42, 'name' => 'Alice Doe'],
    source: 'v2',
);
```

Правила резолва:
- Если `source` передан в гидратор то берется Map(source) ?? Map(null) ?? имя свойства
- Если `source` не передан в гидратор то берется Map(null) ?? имя свойства

`source` пробрасывается во вложенные DTO и элементы массивов автоматически.

## Что умеет гидратор

- Скаляры с приведением типов (`"42"` → `int 42`).
- `enum` и `BackedEnum` — по значению.
- `DateTime` / `DateTimeImmutable` — из строки или таймстампа.
- Вложенные DTO и массивы DTO (через `#[ArrayTypeOf]`).
- Union-типы — выбирается первый совместимый по структуре вариант.
- Дефолтные значения из `__construct` — если поля нет во входных данных.
- Переименование полей через `#[Map]` — для несовпадающих с DTO ключей во входных данных.

## Кэш гидраторов

`HydratorTrait::getHydrator()` отдаёт `Hydrator` из `HydratorRegistry` — на класс создаётся ровно один экземпляр за процесс, парсинг рефлексии не повторяется. Никакой ручной настройки не требуется.

## Исключения

Все ошибки гидратации наследуются от `EntelisTeam\DTOHydrator\Exception\HydrationException`:

- `RequiredArgumentException` — обязательное поле отсутствует во входных данных.
- `ArgumentTypeException` — значение нельзя привести к объявленному типу.

Оба исключения несут JSON-путь до проблемного поля, чтобы сообщение об ошибке сразу указывало место.

## License

MIT.
