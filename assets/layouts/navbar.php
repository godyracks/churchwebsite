
<style>
    .logo-image {
        max-width: 100px;
        height: auto;
    }
</style>
<div id="decorative2">
    <div class="container">

        <div class="divPanel topArea notop nobottom">
            <div class="row-fluid">
                <div class="span12">

                    <div id="divLogo" class="pull-left">
                        <a href="../home" id="divSiteTitle">                        <a href="../home" id="divSiteTitle">
                            <img src="../images/sda-logo1.jpg" alt="Logo" class="logo-image">
                        </a><br />

                        <a href="../home" id="divTagLine">SDA Crater Church</a>
                    </div>

                    <div id="divMenuRight" class="pull-right">
                        <div class="navbar">
                            <button type="button" class="btn btn-navbar-highlight btn-large btn-primary" data-toggle="collapse" data-target=".nav-collapse">menu  <span class="icon-chevron-down icon-white"></span>
                            </button>
                            <div class="nav-collapse collapse">
                                <ul class="nav nav-pills ddmenu">
                                    <li class="dropdown"><a href="../">Home</a></li>
                                    <?php
                                   //session_start();
                                    // Check if the user is an admin based on their email
                                    if (isset($_SESSION['SESSION_EMAIL']) && $_SESSION['SESSION_EMAIL'] == 'onyinkwagodfrey68@gmail.com') {
                                        echo '<li class="dropdown active"><a href="../admin">Admin</a></li>';
                                    }
                                    
                                    ?>
                                    <li class="dropdown active"><a href="../sermon-library" class="dropdown-toggle">Sermon Library <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="../articles">Articles</a></li>
                                            <li class="dropdown">
                                                <a href="../sermon-library" class="dropdown-toggle">Events &nbsp;&raquo;</a>
                                                <ul class="dropdown-menu sub-menu">
                                                    <li><a href="#">Sermon Videos</a></li>
                                                    <li><a href="#">Ministries</a></li>
                                                    <li><a href="#">Upcoming Events</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown "><a href="../about">About</a></li>
                                    <li class="dropdown"><a href="../contact">Contact</a></li>
                                    <li class="dropdown"><a href="../login">Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
