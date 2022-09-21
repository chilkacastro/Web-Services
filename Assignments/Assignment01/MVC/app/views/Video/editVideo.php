<?php require APPROOT . '/views/includes/header.php'; ?>
    <h1>Update Users View</h1>
    <p>This view is invoked by UserController and the updateUser() is executed</p>
    
       
    <form action='' method='post' enctype='multipart/form-data'>

    <div class="form-group">
        <label for="nameinput">Name</label>
        <input name="name" type="text" class="form-control" id="nameinput" value="<?php echo $data->video_name?>">
    </div>
    <div class="form-group">
        <label for="phoneinput">Phone</label>
        <input name="video" type="file" class="form-control" id="fileinput"/>
    </div>

    <button type="submit" name='update' class="btn btn-primary" style='margin-top:35px;'>Update</button>
    </form>

<?php require APPROOT . '/views/includes/footer.php'; ?>