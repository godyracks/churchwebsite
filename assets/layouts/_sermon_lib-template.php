

<div class="container">
    <div class="divPanel page-content">
        <div class="breadcrumbs">
            <a href="../home">Home</a> &nbsp;/&nbsp; <span> Ministries, Sermons & Events</span>
        </div>

        <div class="row-fluid">
            <!-- Sidebar Content -->
            <div class="span3">
            <?php foreach ($events as $event) { ?>
                <h3>Upcoming Events</h3>
                <h3><?php echo $event['title']; ?></h3>
                <p><?php echo htmlspecialchars_decode($event['description']); ?></p>
                <p><?php echo $event['event_date']; ?></p>
                <?php } ?>

                <h3>Ministries</h3>
                <img src="../images/sunset.jpg" class="img-polaroid" alt="">
                <?php foreach ($ministries as $ministry) { ?>
                    <h3><?php echo $ministry['name']; ?></h3>
                    <p><?php echo $ministry['description']; ?></p>
                <?php } ?>
            </div>

            <!-- Main Content Area -->
            <div class="span6" id="divMain">
                    <h3>Sermons</h3>
            <?php foreach ($sermons as $sermon) { ?>
                <h2><?php echo $sermon['title']; ?></h2>
                <hr>
              <p><?php echo htmlspecialchars_decode($sermon['description']); ?></p>
              <hr>
              <hr>
                <?php } ?>
            </div>

            <!-- Sidebar Content -->
            <div class="span3">
                <h3>Choir Ministry</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and <a href="#">typesetting industry</a>.</p>
                <p> Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s.</p>

                <h3>Latest Sermon Videos</h3>
                <div id="videosContainer">
                    <?php
                    foreach ($videos as $video) {
                    ?>
                        <h4><?php echo $video['title']; ?></h4>
                        <article class="youtube video flex-video">
                            <iframe width="560" height="315" src="<?php echo $video['url']; ?>"></iframe>
                        </article>
                    <?php
                    }
                    ?>
                </div>

                <button id="loadMoreBtn">Load More</button>

                <h3>Elderly</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and <a href="#">typesetting industry</a>.</p>
                <p> Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s.</p>
            </div>
        </div>
    </div>
</div>
