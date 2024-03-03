<?php
use App\Models\ModelAdmin;

    if(empty($_POST['admins'])) {

        $_SESSION['error_message'] = lang('TraitCRUDAdmin.wrong_select');
        header('location:' . base_url('/admin/delete'));
        exit;
    }


    $idAdminRecup = htmlentities($_POST['admins']); 

    $modelAdmin = model(ModelAdmin::class);

    $count_admin = 0;
    $admins = $modelAdmin->getAdmins();
        foreach ($admins as $a) {
            $count_admin ++;
        }

    if($idAdminRecup == $_SESSION['idAdmin']) {

        if ($count_admin > 1) {
            $modelAdmin->deleteAdmin($idAdminRecup);
            $_SESSION['password_oublie_message'] = lang('TraitCRUDAdmin.success_delete_admin'); //Je conserve le css bien que la session soit destinée à la validation du mot de passe
            unset($_SESSION['idAdmin']);
            setcookie('token', '', 0, '/');
            header('location:' . base_url('/admin/login'));
            exit;
        }
        else {
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.only_one_admin_left');
            header('location:' . base_url('/admin/delete'));
            exit;
        }
        

    } else {

        if ($count_admin > 1) {
            $modelAdmin->deleteAdmin($idAdminRecup);
            $_SESSION['valid_message'] = lang('TraitCRUDAdmin.success_delete_admin'); //Je conserve le css bien que la session soit destinée à la validation du mot de passe
            header('location:' . base_url('/admin'));
            exit;
        }
        else {
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.only_one_admin_left');
            header('location:' . base_url('/admin/delete'));
            exit;
        }
        
    }

?>