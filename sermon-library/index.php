<?php
// Include the necessary database connection and configuration files
include_once '../assets/setup/db.php';

// Fetch sermons
$sermons_query = mysqli_query($conn, "SELECT * FROM sermons");
$sermons = mysqli_fetch_all($sermons_query, MYSQLI_ASSOC);

// Fetch upcoming events
$events_query = mysqli_query($conn, "SELECT * FROM events");
$events = mysqli_fetch_all($events_query, MYSQLI_ASSOC);

$displayLimit = 4; // Set the desired display limit
// Fetch sermon videos (latest first, limited by displayLimit)
$videos_query = mysqli_query($conn, "SELECT * FROM sermon_videos ORDER BY id DESC LIMIT $displayLimit");
$videos = mysqli_fetch_all($videos_query, MYSQLI_ASSOC);


// Fetch ministries
$ministries_query = mysqli_query($conn, "SELECT * FROM ministries");
$ministries = mysqli_fetch_all($ministries_query, MYSQLI_ASSOC);
?>


<?php require_once('../assets/layouts/header.php'); ?>
<div id="contentOuterSeparator"></div>
<?php require_once('../assets/layouts/_sermon_lib-template.php'); ?>







<?php require_once('../assets/layouts/footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
                <script>
                    $(document).ready(function() {
                        var videosContainer = $("#videosContainer");
                        var loadMoreBtn = $("#loadMoreBtn");
                        var videos = <?php echo json_encode($videos); ?>;
                        var displayLimit = 3;
                        var loadLimit = 6;
                        var offset = displayLimit;

                                                        function loadMoreVideos() {
                                    var remainingVideos = videos.length - offset;
                                    var videosToAdd = videos.slice(offset, offset + Math.min(loadLimit, remainingVideos));

                                    videosToAdd.forEach(function(video) {
                                        var videoHtml = '<h4>' + video.title + '</h4>' +
                                            '<article class="youtube video flex-video">' +
                                            '<iframe width="560" height="315" src="' + video.url + '"></iframe>' +
                                            '</article>';
                                        videosContainer.append(videoHtml);
                                    });

                                    offset += videosToAdd.length;

                                    if (remainingVideos <= loadLimit) {
                                        loadMoreBtn.hide();
                                    }
                                }


                        loadMoreBtn.click(loadMoreVideos);
                    });
                </script>