
<?php require_once('includes/index.php'); 

?>
<?php require_once('../assets/layouts/header.php'); ?>

<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i></div>';
   }
}
?>

<div id="headerSeparator"></div>
<div id="headerSeparator2"></div>
<div id="headerSeparator2"></div>
<div id="contentOuterSeparator"></div>
<br>
<br>
<?php if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);

    echo "Welcome " . $row['name'] . " <a href='../logout'>Logout</a>";
}
?>

<div class="container">
   <div class="divPanel page-content">
      <div class="row">
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">Add a New Sermon</div>
               <div class="card-body">
                  <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
                     <input type="text" name="sermon_title" placeholder="Enter the sermon title" class="box" required>
                     <textarea name="sermon_description" placeholder="Enter the sermon description" id="myEditor" required style="display:none;"></textarea>
                     <input type="file" name="sermon_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
                     <input type="submit" value="Add Sermon" name="add_sermon" class="btn btn-primary">
                  </form>
               </div>
            </div>

            <div class="card">
               <div class="card-header">Add a New Event</div>
               <div class="card-body">
                  <form action="" method="post" class="add-product-form">
                     <input type="text" name="event_title" placeholder="Enter the event title" class="form-control" required>
                     <textarea name="event_description" placeholder="Enter the event description" id="myEditor" required></textarea>
                     <input type="date" name="event_date" placeholder="Select the event date" class="form-control" required>
                     <input type="submit" value="Add Event" name="add_event" class="btn btn-primary">
                  </form>
               </div>
            </div>
         </div>

         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">Add a New Sermon Video</div>
               <div class="card-body">
                  <form action="" method="post" class="add-product-form">
                     <input type="text" name="sermon_video_title" placeholder="Enter the sermon video title" class="form-control" required>
                     <input type="url" name="sermon_video_url" placeholder="Enter the sermon video URL" class="form-control" required>
                     <input type="submit" value="Add Sermon Video" name="add_sermon_video" class="btn btn-primary">
                  </form>
               </div>
            </div>

            <div class="card">
               <div class="card-header">Add a New Ministry</div>
               <div class="card-body">
                  <form action="" method="post" class="add-product-form">
                     <input type="text" name="ministry_name" placeholder="Enter the ministry name" class="form-control" required>
                     <textarea name="ministry_description" placeholder="Enter the ministry description" id="myEditor" required></textarea>
                     <input type="submit" value="Add Ministry" name="add_ministry" class="btn btn-primary">
                  </form>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">Sermons</div>
               <div class="card-body">
                  <?php
                  $select_sermons = mysqli_query($conn, "SELECT * FROM `sermons`");
                  if (mysqli_num_rows($select_sermons) > 0) {
                     while ($row = mysqli_fetch_assoc($select_sermons)) {
                        echo '
                           <div class="product-card">
                              <div class="card-body">
                                 <img src="../assets/uploads/'.$row['image'].'" alt="'.$row['title'].'">
                                 <div class="product-info">
                                    <h4>'.$row['title'].'</h4>
                                    <p>'.htmlspecialchars_decode($row['description']).'</p>
                                    <a href="../admin/index.php?delete='.$row['id'].'" class="delete-btn">
                                       <i class="fas fa-trash"></i> Delete
                                    </a>
                                 </div>
                              </div>
                           </div>
                        ';
                     }
                  } else {
                     echo '<p>No sermons found</p>';
                  }
                  ?>
               </div>
            </div>
         </div>

         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">Upcoming Events</div>
               <div class="card-body">
                  <?php
                  $select_events = mysqli_query($conn, "SELECT * FROM `events`");
                  if (mysqli_num_rows($select_events) > 0) {
                     while ($row = mysqli_fetch_assoc($select_events)) {
                        echo '
                           <div class="event-card">
                              <div class="card-body">
                                 <div class="event-info">
                                    <h4>'.$row['title'].'</h4>
                                    <p>'.htmlspecialchars_decode($row['description']).'</p>
                                    <p>'.$row['event_date'].'</p>
                                    <div class="btn-group">
                                       <a href="../admin/index.php?delete_event='.$row['id'].'" class="btn btn-danger delete">
                                          <i class="fas fa-trash-alt"></i> Delete
                                       </a>
                                       <a href="#" class="btn btn-primary edit">
                                          <i class="fas fa-edit"></i> Edit
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        ';
                     }
                  } else {
                     echo '<p>No events found</p>';
                  }
                  ?>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">Sermon Videos</div>
               <div class="card-body">
                  <?php
                  $select_sermon_videos = mysqli_query($conn, "SELECT * FROM `sermon_videos`");
                  if (mysqli_num_rows($select_sermon_videos) > 0) {
                     while ($row = mysqli_fetch_assoc($select_sermon_videos)) {
                        echo '
                           <div class="sermon-video-card">
                              <div class="card-body">
                                 <div class="sermon-video-info">
                                    <h4>'.$row['title'].'</h4>
                                    <p>'.$row['url'].'</p>
                                    <div class="btn-group">
                                       <a href="../admin/index.php?delete_sermon_video='.$row['id'].'" class="btn btn-danger delete">
                                          <i class="fas fa-trash-alt"></i> Delete
                                       </a>
                                       <a href="#" class="btn btn-primary edit">
                                          <i class="fas fa-edit"></i> Edit
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        ';
                     }
                  } else {
                     echo '<p>No sermon videos found</p>';
                  }
                  ?>
               </div>
            </div>
         </div>

         <div class="col-lg-6">
            <div class="card">
               <div class="card-header">Ministries</div>
               <div class="card-body">
                  <?php
                  $select_ministries = mysqli_query($conn, "SELECT * FROM `ministries`");
                  if (mysqli_num_rows($select_ministries) > 0) {
                     while ($row = mysqli_fetch_assoc($select_ministries)) {
                        echo '
                           <div class="ministry-card">
                              <div class="card-body">
                                 <div class="ministry-info">
                                    <h4>'.$row['name'].'</h4>
                                    <p>'.htmlspecialchars_decode($row['description']).'</p>
                                    <div class="btn-group">
                                       <a href="../admin/index.php?delete_ministry='.$row['id'].'" class="btn btn-danger delete">
                                          <i class="fas fa-trash-alt"></i> Delete
                                       </a>
                                       <a href="#" class="btn btn-primary edit">
                                          <i class="fas fa-edit"></i> Edit
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        ';
                     }
                  } else {
                     echo '<p>No ministries found</p>';
                  }
                  ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php require_once('../assets/layouts/footer.php'); ?>
<script>
   // Initialize CKEditor on textarea elements with the 'custom-editor' class
   document.querySelectorAll('textarea.custom-editor').forEach(textarea => {
      ClassicEditor
         .create(textarea)
         .catch(error => {
            console.error(error);
         });
   });
</script>