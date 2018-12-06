<?php

// Register our autoload.
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


// Connect to the database
$db = Database::DB();

// Instance an object $vehicleManager with our PDO object
$accountManager = new AccountManager($db);

// Add account
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
        $id = intval($_POST['id']);
        $account = $accountManager->getAccount($id);
        $account->creditAccount($balance); 
        $accountManager->updateAccount($account);

    // Debit
    }else
    {
        if (isset($_POST['debit'])) 
        { 
            $balance = intval($_POST['balance']);
            $id = intval($_POST['id']);
            $account = $accountManager->getAccount($id);
            $account->debitAccount($balance); 
            $accountManager->updateAccount($account);
        }
    }
}

// Transfer from one account to another
if(isset($_POST['balanceTransfer']) && !empty($_POST['balanceTransfer']) 
&& isset($_POST['idDebit']) 
&& isset($_POST['transfer']))
{

    $balanceTransfer = intval($_POST['balanceTransfer']);
    $idDebit = intval($_POST['idDebit']);
    $idPayment = intval($_POST['idPayment']);

    $account = $accountManager->getAccount($idDebit);
    $account->debitAccount($balanceTransfer);
    $accountManager->updateAccount($account);

    $transferAccount = $accountManager->getAccount($idPayment);
    $transferAccount->creditAccount($balanceTransfer);
    $accountManager->updateAccount($transferAccount);
    
}

// Get all accounts to display cards
$accounts = $accountManager->getAccounts();

// Get all accounts to display available accounts to select for transfer
$transferAccounts = $accountManager->getAccounts();


include "../views/indexView.php";
