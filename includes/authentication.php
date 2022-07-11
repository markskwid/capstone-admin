<?php
include 'dbcon.php';

use Firebase\Auth\Token\Exception\InvalidToken;
$alert = '';


    if(isset($_POST['admin-login'])){
        $admin_email = $_POST['admin-email'];
        $clearTextPassword = $_POST['admin-password'];
      
        try {
            $user = $auth->getUserByEmail($admin_email);
          
            try{
                $signInResult = $auth->signInWithEmailAndPassword($admin_email, $clearTextPassword);
                
                $idTokenString = $signInResult->idToken();

                try {
                    $verifiedIdToken = $auth->verifyIdToken($idTokenString);
                    header("location: ./dashboard.php");
                } catch (InvalidToken $e) {
                    $alert = '<div class="alert text-center alert-danger">
                                <strong>Invalid Email Address!</strong>
                                </div>';
                } catch (\InvalidArgumentException $e) {
                    $alert = '<div class="alert text-center alert-danger">
                                <strong>Invalid Email Address!</strong>
                                </div>';
                }

                }catch(Exception $e){
                     $alert = '<div class="alert text-center alert-danger">
                                <strong>Wrong Password!</strong>
                                </div>';
                }

           
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            //echo $e->getMessage();
             $alert = '<div class="alert text-center alert-danger">
            <strong>Wrong Email or Phone!</strong>
            </div>';
        }
    }