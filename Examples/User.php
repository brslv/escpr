<?php

namespace Escpr\Examples;

/**
 * Class User
 * 
 * A simple proof-of-a-concept class.
 *
 * @author brslv
 */
class User 
{
	private $firstName;

	private $lastName;

	public function __construct($firstName, $lastName)
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;		    
	}	
    
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function __toString()
    {
        return 'User object: ' . $this->getFirstName() . ' ' . $this->getLastName();
    }
}