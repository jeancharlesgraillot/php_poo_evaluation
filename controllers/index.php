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

if (isset($_POST['id'])) {
    $delete = intval($_POST['id']);        
    $accountManager->deleteAccount($delete);
}

$accounts = $accountManager->getAccounts();


include "../views/indexView.php";
