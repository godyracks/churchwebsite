<?php
   session_start();
   if (!isset($_SESSION['SESSION_EMAIL'])) {
       header("Location:../login");
       die();
   }

require_once('./../assets/setup/db.php');

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");





// Function to sanitize user input
function sanitizeInput($input)
{
    global $conn;
    $input = mysqli_real_escape_string($conn, $input);
    $input = htmlspecialchars($input);
    return $input;
}

// Add Sermon
if (isset($_POST['add_sermon'])) {
    $sermon_title = sanitizeInput($_POST['sermon_title']);
    $sermon_description = sanitizeInput($_POST['sermon_description']);

    // Validate and process the uploaded image
    if (isset($_FILES['sermon_image'])) {
        $sermon_image = $_FILES['sermon_image']['name'];
        $sermon_image_tmp_name = $_FILES['sermon_image']['tmp_name'];
        $sermon_image_folder = './../assets/uploads/' . $sermon_image;

        // Check if the uploaded file is an image
        $image_info = getimagesize($_FILES['sermon_image']['tmp_name']);
        if ($image_info === false) {
            $message[] = 'Please upload a valid image file.';
        } else {
            // Move the uploaded image to the destination folder
            move_uploaded_file($sermon_image_tmp_name, $sermon_image_folder);

            // Insert the sermon record into the database
            $insert_query = mysqli_prepare($conn, "INSERT INTO `sermons` (title, description, image) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insert_query, "sss", $sermon_title, $sermon_description, $sermon_image);
            mysqli_stmt_execute($insert_query);

            if (mysqli_stmt_affected_rows($insert_query) > 0) {
                header('location:../admin/');
                $message[] = 'Sermon added successfully';
            } else {
                $message[] = 'Could not add the sermon';
            }

            mysqli_stmt_close($insert_query);
        }
    } else {
        $message[] = 'Please upload an image for the sermon';
    }
}

// Delete Sermon
if (isset($_GET['delete'])) {
    $delete_id = sanitizeInput($_GET['delete']);
    $delete_query = mysqli_prepare($conn, "DELETE FROM `sermons` WHERE id = ?");
    mysqli_stmt_bind_param($delete_query, "i", $delete_id);
    mysqli_stmt_execute($delete_query);

    if (mysqli_stmt_affected_rows($delete_query) > 0) {
        header('location:../admin/index.php');
        $message[] = 'Sermon has been deleted';
    } else {
        header('location:../admin/index.php');
        $message[] = 'Sermon could not be deleted';
    }

    mysqli_stmt_close($delete_query);
}

// Update Sermon
if (isset($_POST['update_sermon'])) {
    $update_sermon_id = sanitizeInput($_POST['update_sermon_id']);
    $update_sermon_title = sanitizeInput($_POST['update_sermon_title']);
    $update_sermon_description = sanitizeInput($_POST['update_sermon_description']);

    // Validate and process the uploaded image
    if (isset($_FILES['update_sermon_image'])) {
        $update_sermon_image = $_FILES['update_sermon_image']['name'];
        $update_sermon_image_tmp_name = $_FILES['update_sermon_image']['tmp_name'];
        $update_sermon_image_folder = './../assets/uploads/' . $update_sermon_image;

        // Check if the uploaded file is an image
        $image_info = getimagesize($_FILES['update_sermon_image']['tmp_name']);
        if ($image_info === false) {
            $message[] = 'Please upload a valid image file.';
        } else {
            // Move the uploaded image to the destination folder
            move_uploaded_file($update_sermon_image_tmp_name, $update_sermon_image_folder);

            // Update the sermon record in the database
            $update_query = mysqli_prepare($conn, "UPDATE `sermons` SET title = ?, description = ?, image = ? WHERE id = ?");
            mysqli_stmt_bind_param($update_query, "sssi", $update_sermon_title, $update_sermon_description, $update_sermon_image, $update_sermon_id);
            mysqli_stmt_execute($update_query);

            if (mysqli_stmt_affected_rows($update_query) > 0) {
                $message[] = 'Sermon updated successfully';
                header('location:../admin/index.php');
            } else {
                $message[] = 'Sermon could not be updated';
                header('location:../admin/index.php');
            }

            mysqli_stmt_close($update_query);
        }
    } else {
        // Update the sermon record in the database without changing the image
        $update_query = mysqli_prepare($conn, "UPDATE `sermons` SET title = ?, description = ? WHERE id = ?");
        mysqli_stmt_bind_param($update_query, "ssi", $update_sermon_title, $update_sermon_description, $update_sermon_id);
        mysqli_stmt_execute($update_query);

        if (mysqli_stmt_affected_rows($update_query) > 0) {
            $message[] = 'Sermon updated successfully';
            header('location:../admin/index.php');
        } else {
            $message[] = 'Sermon could not be updated';
            header('location:../admin/index.php');
        }

        mysqli_stmt_close($update_query);
    }
}

// Add Event
if (isset($_POST['add_event'])) {
    $event_title = sanitizeInput($_POST['event_title']);
    $event_description = sanitizeInput($_POST['event_description']);
    $event_date = sanitizeInput($_POST['event_date']);

    $insert_query = mysqli_prepare($conn, "INSERT INTO `events` (title, description, event_date) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insert_query, "sss", $event_title, $event_description, $event_date);
    mysqli_stmt_execute($insert_query);

    if (mysqli_stmt_affected_rows($insert_query) > 0) {
        $message[] = 'Event added successfully';
    } else {
        $message[] = 'Could not add the event';
    }

    mysqli_stmt_close($insert_query);
}

// Delete Event
if (isset($_GET['delete_event'])) {
    $delete_event_id = sanitizeInput($_GET['delete_event']);
    $delete_event_query = mysqli_prepare($conn, "DELETE FROM `events` WHERE id = ?");
    mysqli_stmt_bind_param($delete_event_query, "i", $delete_event_id);
    mysqli_stmt_execute($delete_event_query);

    if (mysqli_stmt_affected_rows($delete_event_query) > 0) {
        header('location:../admin/index.php');
        $message[] = 'Event has been deleted';
    } else {
        header('location:../admin/index.php');
        $message[] = 'Event could not be deleted';
    }

    mysqli_stmt_close($delete_event_query);
}

// Update Event
if (isset($_POST['update_event'])) {
    $update_event_id = sanitizeInput($_POST['update_event_id']);
    $update_event_title = sanitizeInput($_POST['update_event_title']);
    $update_event_description = sanitizeInput($_POST['update_event_description']);
    $update_event_date = sanitizeInput($_POST['update_event_date']);

    $update_event_query = mysqli_prepare($conn, "UPDATE `events` SET title = ?, description = ?, event_date = ? WHERE id = ?");
    mysqli_stmt_bind_param($update_event_query, "sssi", $update_event_title, $update_event_description, $update_event_date, $update_event_id);
    mysqli_stmt_execute($update_event_query);

    if (mysqli_stmt_affected_rows($update_event_query) > 0) {
        $message[] = 'Event updated successfully';
        header('location:../admin/index.php');
    } else {
        $message[] = 'Event could not be updated';
        header('location:../admin/index.php');
    }

    mysqli_stmt_close($update_event_query);
}

// Add Sermon Video
if (isset($_POST['add_sermon_video'])) {
    $sermon_video_title = sanitizeInput($_POST['sermon_video_title']);
    $sermon_video_url = sanitizeInput($_POST['sermon_video_url']);

    // Insert the sermon video record into the database
    $insert_query = mysqli_prepare($conn, "INSERT INTO `sermon_videos` (title, url) VALUES (?, ?)");
    mysqli_stmt_bind_param($insert_query, "ss", $sermon_video_title, $sermon_video_url);
    mysqli_stmt_execute($insert_query);

    if (mysqli_stmt_affected_rows($insert_query) > 0) {
        $message[] = 'Sermon video added successfully';
    } else {
        $message[] = 'Could not add the sermon video';
    }

    mysqli_stmt_close($insert_query);
}



// Delete  Sermon Videos
if (isset($_GET['delete_sermon_video'])) {
    $delete_id = sanitizeInput($_GET['delete_sermon_video']);
    $delete_query = mysqli_prepare($conn, "DELETE FROM `sermon_videos` WHERE id = ?");
    mysqli_stmt_bind_param($delete_query, "i", $delete_id);
    mysqli_stmt_execute($delete_query);

    if (mysqli_stmt_affected_rows($delete_query) > 0) {
        header('location:../admin/index.php');
        $message[] = 'Sermon Video has been deleted';
    } else {
        header('location:../admin/index.php');
        $message[] = 'Sermon video could not be deleted';
    }

    mysqli_stmt_close($delete_query);
}

// Add Ministry
if (isset($_POST['add_ministry'])) {
    $ministry_name = sanitizeInput($_POST['ministry_name']);
    $ministry_description = sanitizeInput($_POST['ministry_description']);

    // Insert the ministry record into the database
    $insert_query = mysqli_prepare($conn, "INSERT INTO `ministries` (name, description) VALUES (?, ?)");
    mysqli_stmt_bind_param($insert_query, "ss", $ministry_name, $ministry_description);
    mysqli_stmt_execute($insert_query);

    if (mysqli_stmt_affected_rows($insert_query) > 0) {
        $message[] = 'Ministry added successfully';
    } else {
        $message[] = 'Could not add the ministry';
    }

    mysqli_stmt_close($insert_query);
}


// Delete  Ministry
if (isset($_GET['delete_ministry'])) {
    $delete_id = sanitizeInput($_GET['delete_ministry']);
    $delete_query = mysqli_prepare($conn, "DELETE FROM `ministries` WHERE id = ?");
    mysqli_stmt_bind_param($delete_query, "i", $delete_id);
    mysqli_stmt_execute($delete_query);

    if (mysqli_stmt_affected_rows($delete_query) > 0) {
        header('location:../admin/index.php');
        $message[] = 'Ministry has been deleted';
    } else {
        header('location:../admin/index.php');
        $message[] = 'Ministry  could not be deleted';
    }

    mysqli_stmt_close($delete_query);
}


?>


