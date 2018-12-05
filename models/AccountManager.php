<?php

declare(strict_types = 1);

class AccountManager
{

// propriétés et méthodes de votre manager ici
    private $_db;


    /**
     * constructor
     *
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    /**
     * Get the value of _db
     */ 
    public function getDb()
    {
        return $this->_db;
    }

    /**
     * Set the value of _db
     *
     * @param PDO $db
     * @return  self
     */ 
    public function setDb(PDO $db)
    {
        $this->_db = $db;

        return $this;
    }


    public function getAccounts()
    {
        // Array declaration
        $arrayOfAccounts = [];

        $query = $this->getDB()->prepare('SELECT * FROM accounts');
        $query->execute();
        $dataAccounts = $query->fetchAll(PDO::FETCH_ASSOC);

        // At each loop, we create a new account object wich is stocked in our array $arrayOfAccounts
        foreach ($dataAccounts as $dataAccount) {

            $arrayOfAccounts[] = new Account($dataAccount);

        }

        // Return of the array on which we could loop to list all accounts
        return $arrayOfAccounts;
    }

    /**
     * Get one account by id or name
     *
     * @param $info
     * @return Account 
     */
    public function getAccount($id)
    {

        // get by id
        $id = (int)$id;
        $query = $this->getDB()->prepare('SELECT * FROM accounts WHERE id = :id');
        $query->bindValue('id', $id, PDO::PARAM_INT);
        $query->execute();
        

        // $dataAccount est un tableau associatif contenant les informations d'un personnage
        $dataAccount = $query->fetch(PDO::FETCH_ASSOC);

        // We create a new account object with the associative array $dataAccount and return it
        return new Account($dataAccount);
    }


        /**
     * Add account into DB
     *
     * @param Account $account
     */
    public function addAccount(Account $account)
    {
        $query = $this->getDb()->prepare('INSERT INTO accounts(name, balance) VALUES (:name, :balance)');
        $query->bindValue('name', $account->getName(), PDO::PARAM_STR);
        $query->bindValue('balance', $account->getBalance(), PDO::PARAM_INT);
       

        $query->execute();

    }

        /**
     * Check if account exists or not
     *
     * @param string $name
     * @return boolean
     */
    public function checkIfExist(string $name)
    {
        $query = $this->getDb()->prepare('SELECT * FROM accounts WHERE name = :name');
        $query->bindValue('name', $name, PDO::PARAM_STR);
        $query->execute();

        // If there's an entry with that name, that's it exists
        if ($query->rowCount() > 0)
        {
            return true;
        }
        
        // Else, it doesn't exist
        return false;
    }

        /**
     * Update account's data 
     *
     * @param Account $account
     */
    public function updateAccount(Account $account)
    {   
        
        $query = $this->getDb()->prepare('UPDATE accounts SET name = :name, balance = :balance WHERE id = :id');
        $query->bindValue('id', $account->getId(), PDO::PARAM_INT);
        $query->bindValue('name', $account->getName(), PDO::PARAM_STR);
        $query->bindValue('balance', $account->getBalance(), PDO::PARAM_INT);
        $query->execute();
    }

        /**
     * Delete account from DB
     *
     * @param Account $account
     */
    public function deleteAccount($id)
    {
        $id = (int)$id;
        $query = $this->getDb()->prepare('DELETE FROM accounts WHERE id = :id');
        $query->bindValue('id', $id, PDO::PARAM_INT);
        $query->execute();
    }

}
