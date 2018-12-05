<?php

declare(strict_types = 1);

class Account
{

    // Properties and methods
    
    private $id;
    private $name;
    private $balance = 0;

    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->hydrate($array);
    }

    /**
     * Hydratation
     *
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            // We get the setter name linked to the attribute
            $method = 'set'.ucfirst($key);
                
            // If corresponding setter exists
            if (method_exists($this, $method))
            {
                // We call the setter.
                $this->$method($value);
            }
        }
    }

    /**
     * Get the value of id
    */ 
    public function getId()
    {
    return $this->id;
    }

    /**
     * Set the value of id
    *
    * @return  self
    */ 
    public function setId($id)
    {
    $this->id = $id;

    return $this;
    }

    /**
     * Get the value of name
    */ 
    public function getName()
    {
    return $this->name;
    }

    /**
     * Set the value of name
    *
    * @return  self
    */ 
    public function setName($name)
    {
    $this->name = $name;

    return $this;
    }

    /**
     * Get the value of balance
    */ 
    public function getBalance()
    {
    return $this->balance;
    }

    /**
     * Set the value of balance
    *
    * @return  self
    */ 
    public function setBalance($balance)
    {
    $this->balance = $balance;

    return $this;
    }
}
