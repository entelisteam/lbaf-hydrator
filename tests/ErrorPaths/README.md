# Hydrator Error Path Tests

This directory contains tests that verify human-readable error messages with nested structure paths when hydration fails.

## Error Path Format

When hydration fails, the error message includes the full path to the problematic field using the following syntax:

- `(ClassName)` - class name in parentheses
- `->propertyName` - property accessor
- `[]` - array notation
- `[](ClassName)` - array of objects

### Examples

1. **Simple nested object**: `(Foo)->test1(Bar)->value`
   - Error in `value` field of `Bar` class, nested in `test1` property of `Foo`

2. **Nested array of objects**: `(Foo)->test1(Bar)->items[](Zoo)->required`
   - Error in `required` field of `Zoo` class, inside array `items` of `Bar`, nested in `test1` property of `Foo`

3. **Root array**: `[](RootArrayItem)->name`
   - Error in `name` field of `RootArrayItem` in a root-level array

4. **Union types**: `(Container)->content(TypeB)->fieldB`
   - Error when trying to hydrate union type `TypeA|TypeB`, showing the last attempted type

## Test Coverage

- ✅ Nested objects with missing required fields
- ✅ Arrays of objects with missing required fields
- ✅ Root-level arrays with missing required fields
- ✅ Union types with missing required fields
- ✅ Deep nesting with multiple levels
