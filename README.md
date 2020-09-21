# auto-text-gen

A simple document driven text composer.

## Example

```php
$context = Context::fromArray([
    'trend' => 10,
    'total' => 90,
]);

$decisionTable = DecisionTable::fromArray([
    'isNegative' => false,
]);

$textComposer = new TextComposer($decisionTable, $context);

$result = $textComposer->compose(
    '{In dieser Woche|Aktuell} ist der Wert um ${trend} auf ${total} Punkte ' .
    '[IF $isNegative] gefallen [ELSE] gestiegen [ENDIF].'
);
```

Possible result are:

```text
In dieser Woche ist der Wert um 10 auf 90 Punkte gestiegen.
```

or
```text
Aktuell ist der Wert um 10 auf 90 Punkte gestiegen.
```

## Manipulators

Syntax|Description
---|---
{synonym1&#124;synonym2&#124;synonym3}|Random choose a synonym out of list
${var}|Variable name from context
${decision}|true of false from table of decisions

