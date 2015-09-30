<?php

require_once '../vendor/autoload.php';

use Escpr\Escpr;
use Escpr\Examples\User;

/**
 * Class EscprTest
 * 
 * @author brlsv
 */
class EscprTest extends PHPUnit_Framework_TestCase
{
    public function testItCanEscapeString()
    {
        $string = '<b>Test</b>';
        
        // When Escpr escapes strings, it does not do that by reference.
        // So Escpr always returns new string.
        // In all other complex types (arrays, objects, arrays of objects, etc.),
        // Escpr works by reference (does not return a value).
        $string = Escpr::escape($string);
        
        $this->assertEquals('&lt;b&gt;Test&lt;/b&gt;', $string);
    }
    
    public function testItCanEscapeArrayOfString()
    {
        $arrayOfString = ['<b>Test</b>'];
        
        // Here Escpr works by reference on the original
        // $arrayOfStrings array.
        Escpr::escape($arrayOfString);
        
        $this->assertEquals(['&lt;b&gt;Test&lt;/b&gt;'], $arrayOfString);
    }
    
    public function testItCanEscapeArrayOfArray()
    {
        $arrayOfArray = [
            'go' => [
                '<b>test</b>',
            ],
        ];
        
        Escpr::escape($arrayOfArray);
        
        $this->assertEquals(['go' => ['&lt;b&gt;test&lt;/b&gt;']], $arrayOfArray);
    }
    
    public function testItCanEscapeStringFromObjectProperty()
    {
        $userObject = new User('John', '<b>Doe</b>');
        
        Escpr::escape($userObject);
        
        $this->assertEquals('&lt;b&gt;Doe&lt;/b&gt;', $userObject->getLastName());
    }
    
    public function testItCanEscapeObjectPropertyOfObjectLocatedInArray()
    {
        $arrayOfObject = [new User('John', '<b>Doe</b>')];
        
        Escpr::escape($arrayOfObject);
        
        $this->assertEquals('&lt;b&gt;Doe&lt;/b&gt;', $arrayOfObject[0]->getLastName());
    }
    
    public function testItCanEscapeArrayInsideObjectProperty()
    {
        $userObjectWithArrayProperty = new User('John', ['<b>Doe</b>']);
        
        Escpr::escape($userObjectWithArrayProperty);
        
        $this->assertEquals(['&lt;b&gt;Doe&lt;/b&gt;'], $userObjectWithArrayProperty->getLastName());
    }
}
