<?php

ini_set('display_errors', 1);

/**
 * The following are some example usages of the Escpr class.
 * =========================================================
 * 
 * Using Escpr is a piece of cake. 
 * 
 * Escpr class has a single public method - escape().
 * It's static and works by reference, 
 * meaning directly on a variable's value(s).
 * 
 * But keep in mind - Escpr does not escape stdClass objects!
 * It's still a work in progress. Maybe one day Escpr will be 
 * smart enough to do it. But for now a workaround is to cast 
 * stdClass object to array and after escaping - back to stdClass object (examples bellow).
 * 
 * That's it. 
 * 
 * Start escaping.
 */

require_once '../vendor/autoload.php';

use Escpr\Escpr;
use Escpr\Examples\User;

// Escaping a strings.

$simpleString = '<b>This string should be bold if not escaped correctly.</b>';
Escpr::escape($simpleString); // assign the returned value to a variable.
echo $simpleString . '<br />';

// Escaping arrays.

$simpleArray = ['some' => '<b>String to be escaped</b>'];
Escpr::escape($simpleArray);
echo implode(', ', $simpleArray) . '<br />';

// Escaping objects.
// Note: After the escapeing the original object will have escaped properties.

$simpleUserObject = new User("John", "<b>Doe</b>");
Escpr::escape($simpleUserObject);
echo $simpleUserObject . '<br />';

// Escaping array of arrays.

$complexArray = [
    'some' => [
        'complex' => [
            'stuff' => '<b>here</b>',
        ]
    ]
];
Escpr::escape($complexArray);
echo $complexArray['some']['complex']['stuff'] . '<br />';

// Escaping array of things.

$moreComplexArray = [
    '<u>string</u>',
    
    'some' => [
        'array' => [
            'of' => [
                new User('John', '<b>Doe</b>'),
            ],
            
            'and' => '<b>Another thing</b>',
        ]
    ],
    
    ['<li>and this list item</li>'],
    
    ['and' => [
       'why' => [
           'not' => [
               'this' => [
                   'crazy' => [
                       'thing' => '<script>console.log("hey!")</script>',
                   ]
               ]
           ]
       ] 
    ]],
];
Escpr::escape($moreComplexArray);
array_walk_recursive($moreComplexArray, function ($e) {
   echo $e . '<br />';
});

// Escaping stdClass objects
// NOTE: Escpr does not escape stdClass objects.
// WORKAROUND: 
//      First, cast to array.
//      Second, escape with Escpr::escape().
//      Third, cast back to object.

$stdClassObject = new stdClass(); // create a simple stdClass object.
$stdClassObject->escapeMe = '<script>alert("Rotten tomatoes ftw!")</script>'; // add a property to it.
$stdClassObjectAsArray = (array) $stdClassObject; // because Escpr does not escape stdClass objects, convert it to array.

Escpr::escape($stdClassObjectAsArray); // escape the casted array.

$stdClassObject = (object) $stdClassObjectAsArray; // cast the escaped array back to stdClass object.

echo $stdClassObject->escapeMe . '<br />'; // print the escaped value.