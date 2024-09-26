<?php $globalSettings = (new \App\Models\Setting())->orderBy('id', 'ASC')->GetValues(['company_name','backend_logo']);?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Zaptta Control Panel | <?=$globalSettings[0]['var_detail']?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/jquery-asColorPicker/css/asColorPicker.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/css/vertical-layout-light/all.min.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/css/vertical-layout-light/style.css">
  <!-- endinject -->

  <link rel="apple-touch-icon" sizes="57x57" href="<?php print base_url();?>/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php print base_url();?>/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php print base_url();?>/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php print base_url();?>/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php print base_url();?>/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php print base_url();?>/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php print base_url();?>/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php print base_url();?>/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php print base_url();?>/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php print base_url();?>/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php print base_url();?>/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php print base_url();?>/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php print base_url();?>/favicon-16x16.png">
  <link rel="manifest" href="<?php print base_url();?>/manifest.json">
  <meta name="msapplication-TileColor" content="#fb5000">
  <meta name="msapplication-TileImage" content="<?php print base_url();?>/ms-icon-144x144.png">
  <meta name="theme-color" content="#fb5000">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">
  
  <script src="<?php print base_url() . ADMIN;?>/vendors/js/vendor.bundle.base.js"></script>
  <style type="text/css">
    .addbtn{
        width: 100%;
    }
    .addbtn a{
        width: 60px;
        height: 60px;
        background: #299a18;
        border-radius: 5px;
        text-decoration: none;
        padding-top: 7px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
    }
    .addbtn a span{
        width: 100%;
        display: block;
        text-align: center;
        color: #FFFFFF;
        font-size: 12px;
    }
    .addbtn a span i{
        font-size: 20px;
    }
  </style>
  <script type="text/javascript">
    function loadNotification() {
      let url = '<?=base_url().route_to('admin.notifications')?>';
      $.get(url, function(data){
        if(data.notifications && data.notifications.length){
            if(data.count){
              $('#checkCount').removeClass('d-none');
            }
            var html = `<a class="dropdown-item py-3">
                          <p class="mb-0 font-weight-medium float-left">You have ${data.count} unread mails </p>
                        </a>
                        <div class="dropdown-divider"></div>
                        ${data.notifications.map(function(notif){
                          return `
                                <a href="<?=base_url()?>/admincp/messages/view/${notif.id}" class="dropdown-item preview-item ${!parseInt(notif.read)?'bg-info':''}">
                                  <div class="preview-thumbnail">
                                    <i class="fa fa-envelope${parseInt(notif.read)?'-open':''} icon-lg" style="color: black;"></i> 
                                  </div>
                                  <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">${notif.name}</p>
                                    <p class="fw-light small-text mb-0"> ${notif.message.substring(0,20)}${notif.length>20?'...':''} </p>
                                  </div>
                                </a>`;
                        }).join("")}
                        <div class="text-center mt-3">
                          <button class="btn btn-primary btn-block btn-sm px-5" onclick="window.location.href='<?=base_url()?>/admincp/messages'">View all</button>
                        </div>`; 
        }else{
          var html = `<a class="dropdown-item py-3">
                          <p class="mb-0 font-weight-medium float-left">You have ${data.count} unread mails </p>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">      
                          <div class="preview-item-content flex-grow py-2">
                            <p class="h3">No unread notifications</p>
                          </div>
                        </a>
                        <div class="text-center mt-3">
                          <button class="btn btn-primary btn-block btn-sm px-5" onclick="window.location.href='<?=base_url()?>/admincp/messages'">View all</button>
                        </div>`;
        }
        $('#notificationList').html(html);
      })
      
    }
    loadNotification();
  </script>
</head>
<body class="sidebar-dark with-welcome-text">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="<?php print base_url().'/admincp';?>">
              <img src="<?=base_url().'/upload/logo/'.$globalSettings[1]['var_detail']?>" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
              <!-- <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">John Doe</span></h1> -->
              <!-- <h3 class="welcome-sub-text">Your performance summary this week </h3> -->
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <!-- <li class="nav-item">
              <form class="search-form" action="#">
                <i class="icon-search"></i>
              <input type="search" class="form-control" placeholder="Search Here" title="Search here">
              </form>
            </li> -->
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="icon-bell"></i>
                <span class="count d-none" id="checkCount"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" id="notificationList" aria-labelledby="countDropdown">
                <i class="fa fa-spin fa-spinner"></i>
              </div>
            </li>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="<?php print base_url();?>/favicon-96x96.png" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?php print base_url();?>/favicon-96x96.png" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold"><?= getAdminUserName() ?></p>
                </div>
                <a href="<?=base_url().route_to('admin.profile')?>" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
                <a href="<?=base_url()?>/admincp/messages" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
                <a class="dropdown-item" href="<?php print base_url().'/admincp/logout'?>"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      
      <!-- partial:partials/_sidebar.html -->
      <?php print view('admin/sidebar');?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">