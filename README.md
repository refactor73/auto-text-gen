# auto-text-gen

A simple document driven text composer.

## Description

Writing natural language text blocks based on context and decisions parsed from a JSON document. 
The context contains the properties of the JSON document itself and can be added to the text as ${variables},
 while the decision table contains bool values based on pre executed custom conditions and are used
 in [IF $decision] control structures.

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
[IF $decision] ... [ENDIF]|if control structure
[IF $decision] ... [ELSE] ... [ENDIF]| if else control structure

## Use case

Generating varied text for a customer metric report based on a JSON document.
