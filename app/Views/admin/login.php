
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Zaptta Control Panel</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php print base_url() . ADMIN;?>/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php print base_url() . ADMIN;?>/images/favicon.png" />
</head>

<body class="sidebar-dark">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <h6 class="fw-light">Sign in to continue.</h6>
              <form method="post" action="<?php print base_url().'/admincp/login/auth';?>" class="pt-3">
                <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
                <input type="hidden" name="_redirect_url" value="<?php print isset($_GET['red']) ? $_GET['red'] : base_url().'/admincp';?>">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="user.email" id="Email1" placeholder="Email1" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="user.password" id="Password" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php print base_url() . ADMIN;?>/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?php print base_url() . ADMIN;?>/js/off-canvas.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/hoverable-collapse.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/template.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/settings.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/todolist.js"></script>
  <!-- endinject -->
</body>
</html>
