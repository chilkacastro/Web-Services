<?php require APPROOT . '/views/includes/header.php'; ?>

    <h1>Create Video View</h1>
    
    <form action='' method='post' enctype='multipart/form-data'>

    <div class="form-group">
        <label for="nameinput">Video name</label>
        <input name="name" type="text" class="form-control" id="nameinput" placeholder="Name">
 
    <div class="form-group">
        <label for="videoinput">Video</label>
        <input type='file' name='video' class='form-control' />
    </div>
       </div>

    <button type="submit" name='register' class="btn btn-primary"  style='margin-top:25px;'>Upload Video</button>
    </form>
   
<?php require APPROOT . '/views/includes/footer.php'; ?>