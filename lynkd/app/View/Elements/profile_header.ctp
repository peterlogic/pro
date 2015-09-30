<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<title>Profile</title>
<!-- css file -->
<?php echo $this->Html->css('front/style'); ?>
<?php echo $this->Html->css('front/jquery.jscrollpane'); ?>

<!-- Javascript file -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/hammer.min.js"></script>
<script src="js/html5shiv.js"></script>
<script src="js/custom.js"></script>
<script src="js/sidebar.js"></script>
</head>
<body>
<header>
    
<!-- SIDEBAR -->
<div data-sidebar="true" class="sidebar-trigger">
    <a class="sidebar-toggle" href="#1">
        <span class="sr-only toggle-menu"></span>
    </a>

    <div class="sidebar-wrapper sidebar-default">

           
        <ul>
          <li><a class="active" href="javascript:void()">Home</a></li>
          <li><a href="javascript:void()">Blogs</a></li>
          <li><a href="javascript:void()">Post</a></li>
          <li><a href="javascript:void()">Contact us</a></li>
          <li class="login"><a class="login" href="javascript:void()">Login</a></li>
          <li class="register"><a class="signup" href="javascript:void()">Register</a></li>
        </ul>

    </div>
</div>
    
  <section class="wrapper">
    <div class="logo pull-left"><a href="index.html"><img src="images/logo.png" alt="" /></a></div>
    <section class="nav-search-outer pull-right">
      <nav class="pull-left">
        <ul>
          <li><a href="javascript:void()">Home</a></li>
          <li><a href="javascript:void()">Blogs</a></li>
          <li><a href="javascript:void()">Post</a></li>
          <li><a href="javascript:void()">Contact us</a></li>
          <li class="login"><a class="login" href="javascript:void()">Login</a></li>
          <li class="register"><a class="signup" href="javascript:void()">Register</a></li>
        </ul>
      </nav>
           <div class="profileUser"> <img src="images/onlineuserthumb.jpg" alt=""> <a class="ckl" href="#">Stacey</a>
        <div class="profile-down-window">
          
          <ul class="dropdown-menu with-arrow">

                    <li><a class="user" href="#1"> My Profile</a> </li>
              <li><a class="logout" href="#1"> Logout</a> </li>
                </ul>
          
          </div>
        </div>
    </section>
  </section>
</header>