# auto-text-gen

A simple document driven text composer.

## Example

```php
$pattern = '{In dieser Woche|Aktuell} ist der Wert um ${trend} auf ${total} Punkte ' .
    ' [IF $isNegative] gefallen [ELSE] gestiegen [ENDIF].';

$context = Context::fromArray([
    'trend' => 10,
    'total' => 90,
]);

$decisionTable = DecisionTable::fromArray([
    'isPositive' => true,
]);

$textComposer = new TextComposer($decisionTable, $context);

$result = $textComposer->compose($pattern);
```

Possible result are:

```text
In dieser Woche ist der Wert um 10 auf 90 Punkte gestiegen.
```

or
```text
Aktuell ist der Wert um 10 auf 90 Punkte gestiegen.
```
