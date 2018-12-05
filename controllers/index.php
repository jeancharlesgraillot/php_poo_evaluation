<?php

// On enregistre notre autoload.
function loadClass($classname)
{
    if(file_exists('../models/'. $classname.'.php'))
    {
        require '../models/'. $classname.'.php';
    }
    else 
    {
        require '../entities/' . $classname . '.php';
    }
}
spl_autoload_register('loadClass');


// We connect to the database
$db = Database::DB();

// We instance an object $vehicleManager with our PDO object
$accountManager = new AccountManager($db);


if (isset($_POST['name']) && !empty($_POST['name'])) {

    $name = htmlspecialchars($_POST['name']);

    if (isset($_POST['new'])) 
    {

        if($accountManager->checkIfExist($name))
        {

            $message = "Le compte existe déjà !";
        }
        
        else
        {
           
            $account = new Account([
            'name'=> $name,
            'balance' => 80
            
            ]);

            $accountManager->addAccount($account);

        }

    }    

}

// Delete account

if (isset($_POST['id']) && isset($_POST['delete']))
{
    $delete = intval($_POST['id']);        
    $accountManager->deleteAccount($delete);
}

// Credit and debit account

// Credit
if (isset($_POST['balance']) && !empty($_POST['balance']) && isset($_POST['id'])) 
{
    if (isset($_POST['payment'])) 
    { 
        
        $balance = intval($_POST['balance']);
        $id = $_POST['id'];
        $account = $accountManager->getAccount($id);
        $account->creditAccount($balance); 
        $accountManager->updateAccount($account);
    }
}

// Debit

if (isset($_POST['balance']) && !empty($_POST['balance']) && isset($_POST['id'])) 
{
    if (isset($_POST['debit'])) 
    { 
        
        $balance = intval($_POST['balance']);
        $id = $_POST['id'];
        $account = $accountManager->getAccount($id);
        $account->debitAccount($balance); 
        $accountManager->updateAccount($account);
    }
}

$accounts = $accountManager->getAccounts();


include "../views/indexView.php";
