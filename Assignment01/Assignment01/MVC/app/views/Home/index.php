<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="container"> 
    <?php
        if($data != []){
            echo '<div class="alert alert-success" style="margin-top:25px" role="alert">'.
             $data['msg'].'
          </div>';
        }
    ?>
    <h1>Welcome to TekCompany</h1>
    <h3>Sign up, upload and view your videos</h3>
<?php require APPROOT . '/views/includes/footer.php'; ?>