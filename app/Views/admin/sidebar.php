<?php  $admin_user_perm = getAdminMenuPerm(); ?>      
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp'?>">
              <i class="mdi mdi-grid-large menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <?php  if ( array_key_exists('categories',$admin_user_perm) || array_key_exists('brands',$admin_user_perm) || array_key_exists('attributes',$admin_user_perm) ) { ?>
          <li class="nav-item nav-category">Stores</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Categories" aria-expanded="false" aria-controls="Categories">
              <i class="menu-icon mdi mdi-collage"></i>
              <span class="menu-title">Categories</span>
              <i class="menu-arrow mdi mdi-arrow-right-drop-circle-outline "></i>
            </a>
            <div class="collapse" id="Categories">
              <ul class="nav flex-column sub-menu">
              <?php  if ( array_key_exists('categories',$admin_user_perm) && $admin_user_perm['categories']['view'] == 1 && $admin_user_perm['categories']['allview'] == 1 ) { ?>
                <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/categories';?>">Categories</a></li>
              <?php } ?>
              <?php  if ( array_key_exists('brands',$admin_user_perm) && $admin_user_perm['brands']['view'] == 1 && $admin_user_perm['brands']['allview'] == 1 ) { ?>
                <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/brands';?>">Brands</a></li>
              <?php } ?>
              <?php  if ( array_key_exists('attributes',$admin_user_perm) && $admin_user_perm['attributes']['view'] == 1 && $admin_user_perm['attributes']['allview'] == 1 ) { ?>
                <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/attributes';?>">Attributes</a></li>
              <?php } ?>
              </ul>
            </div>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('products',$admin_user_perm) || array_key_exists('orders',$admin_user_perm) || array_key_exists('coupons',$admin_user_perm) ) { ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#commerce" aria-expanded="false" aria-controls="commerce">
              <i class="menu-icon mdi mdi-cart-arrow-down"></i>
              <span class="menu-title">E-commerce</span>
              <i class="menu-arrow mdi mdi-arrow-right-drop-circle-outline "></i>
            </a>
            <div class="collapse" id="commerce">
              <ul class="nav flex-column sub-menu">
              <?php  if ( array_key_exists('products',$admin_user_perm) && $admin_user_perm['products']['view'] == 1 && $admin_user_perm['products']['allview'] == 1 ) { ?>
                <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/products';?>">Products</a></li>
              <?php } ?>
              <?php  if ( array_key_exists('orders',$admin_user_perm) && $admin_user_perm['orders']['view'] == 1 && $admin_user_perm['orders']['allview'] == 1 ) { ?>
                <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/orders';?>">Orders</a></li>
              <?php } ?>
              <?php  if ( array_key_exists('coupons',$admin_user_perm) && $admin_user_perm['coupons']['view'] == 1 && $admin_user_perm['coupons']['allview'] == 1 ) { ?>
                <!-- <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/coupons';?>">Coupons</a></li> -->
              <?php } ?>
              </ul>
            </div>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('stores',$admin_user_perm) && $admin_user_perm['stores']['view'] == 1 && $admin_user_perm['stores']['allview'] == 1 ) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/vendors';?>">
              <i class="menu-icon mdi mdi-store"></i>
              <span class="menu-title">Stores</span>
            </a>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('payments',$admin_user_perm) && $admin_user_perm['payments']['view'] == 1 && $admin_user_perm['payments']['allview'] == 1 ) { ?>
          <li class="nav-item nav-category">PAYMENTS</li>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/payments';?>">
              <i class="menu-icon mdi mdi-credit-card"></i>
              <span class="menu-title">Payments</span>
            </a>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('customers',$admin_user_perm) && $admin_user_perm['customers']['view'] == 1 && $admin_user_perm['customers']['allview'] == 1 ) { ?>
          <li class="nav-item nav-category">Register Accounts</li>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/customers';?>">
              <i class="menu-icon mdi mdi-account-circle-outline"></i>
              <span class="menu-title">Customers</span>
            </a>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('homepageslider',$admin_user_perm) || array_key_exists('searchslider',$admin_user_perm) ) { ?>
          <li class="nav-item nav-category">Site Content</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Sliders-pages" aria-expanded="false" aria-controls="Sliders-pages">
              <i class="menu-icon mdi mdi-tooltip-image"></i>
              <span class="menu-title">Sliders</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="Sliders-pages">
              <ul class="nav flex-column sub-menu">
        <?php  if ( array_key_exists('homepageslider',$admin_user_perm) && $admin_user_perm['homepageslider']['view'] == 1 && $admin_user_perm['homepageslider']['allview'] == 1 ) { ?>
        <?php } ?>
                <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/sliders/homepage';?>">Homepage</a></li>
        <?php  if ( array_key_exists('searchslider',$admin_user_perm) && $admin_user_perm['searchslider']['view'] == 1 && $admin_user_perm['searchslider']['allview'] == 1 ) { ?>
                <li class="nav-item"> <a class="nav-link" href="<?php print base_url().'/admincp/sliders/search';?>">Title</a></li>
        <?php } ?>
              </ul>
            </div>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('faq',$admin_user_perm) || array_key_exists('terms',$admin_user_perm) || array_key_exists('pages',$admin_user_perm) || array_key_exists('socials',$admin_user_perm) ) { ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Content" aria-expanded="false" aria-controls="Content">
              <i class="menu-icon mdi mdi-book-open"></i>
              <span class="menu-title">Content</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="Content">
              <ul class="nav flex-column sub-menu">
            <?php  if ( array_key_exists('faq',$admin_user_perm) && $admin_user_perm['faq']['view'] == 1 && $admin_user_perm['faq']['allview'] == 1 ) { ?>
               <!--  <li class="nav-item"><a class="nav-link" href="<?php print base_url().'/admincp/faq';?>">Faq`s</a></li> -->
            <?php } ?>
            <?php  if ( array_key_exists('terms',$admin_user_perm) && $admin_user_perm['terms']['view'] == 1 && $admin_user_perm['terms']['allview'] == 1 ) { ?>
                <li class="nav-item"><a class="nav-link" href="<?php print base_url().'/admincp/terms';?>">Terms</a></li>
            <?php } ?>
            <?php  if ( array_key_exists('pages',$admin_user_perm) && $admin_user_perm['pages']['view'] == 1 && $admin_user_perm['pages']['allview'] == 1 ) { ?>
                <li class="nav-item"><a class="nav-link" href="<?php print base_url().'/admincp/pages';?>">Pages</a></li>
            <?php } ?>
            <?php  if ( array_key_exists('socials',$admin_user_perm) && $admin_user_perm['socials']['view'] == 1 && $admin_user_perm['socials']['allview'] == 1 ) { ?>
                <!-- <li class="nav-item"><a class="nav-link" href="<?php //print base_url().'/admincp/socials';?>">Socials</a></li> -->
            <?php } ?>
              </ul>
            </div>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('compain',$admin_user_perm) && $admin_user_perm['compain']['view'] == 1 && $admin_user_perm['compain']['allview'] == 1 ) { ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Campaign" aria-expanded="false" aria-controls="Campaign">
              <i class="menu-icon mdi mdi-message "></i>
              <span class="menu-title">Campaign</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="Campaign">
              <ul class="nav flex-column sub-menu">
            <?php  if ( array_key_exists('compain',$admin_user_perm) && $admin_user_perm['compain']['view'] == 1 && $admin_user_perm['compain']['allview'] == 1 ) { ?>
                <li class="nav-item"><a class="nav-link" href="<?php print base_url().'/admincp/compain';?>">Campaign</a></li>
            <?php } ?>
            <?php  if ( array_key_exists('wheel',$admin_user_perm) && $admin_user_perm['wheel']['view'] == 1 && $admin_user_perm['wheel']['allview'] == 1 ) { ?>
                <li class="nav-item"><a class="nav-link" href="<?php print base_url().'/admincp/wheels';?>">Wheel</a></li>
            <?php } ?>
              </ul>
            </div>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('notification',$admin_user_perm) && $admin_user_perm['notification']['view'] == 1 && $admin_user_perm['notification']['allview'] == 1 ) { ?>
      <!--     <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/notification';?>">
              <i class="menu-icon mdi mdi-bell-ring"></i>
              <span class="menu-title">Notification</span>
            </a>
          </li> -->
        <?php } ?>
        <?php  if ( array_key_exists('media',$admin_user_perm) && $admin_user_perm['media']['view'] == 1 && $admin_user_perm['media']['allview'] == 1 ) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/media';?>">
              <i class="menu-icon mdi mdi-file-image-outline"></i>
              <span class="menu-title">Media</span>
            </a>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('emails',$admin_user_perm) && $admin_user_perm['emails']['view'] == 1 && $admin_user_perm['emails']['allview'] == 1 ) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/newsletter';?>">
              <i class="menu-icon mdi mdi-email-outline"></i>
              <span class="menu-title">E-mails</span>
            </a>
          </li>
        <?php } ?>

        
        <?php  if ( array_key_exists('messages',$admin_user_perm) && $admin_user_perm['messages']['view'] == 1 && $admin_user_perm['messages']['allview'] == 1 ) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/messages';?>">
              <i class="menu-icon mdi mdi-message "></i>
              <span class="menu-title">Messages</span>
            </a>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('reports',$admin_user_perm) && $admin_user_perm['reports']['view'] == 1 && $admin_user_perm['reports']['allview'] == 1 ) { ?>
          <li class="nav-item nav-category">REPORTS</li>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/reports/index';?>">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Reports</span>
            </a>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('users',$admin_user_perm) || array_key_exists('profiles',$admin_user_perm) ) { ?>
          <li class="nav-item nav-category">Admin</li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#admin_users" aria-expanded="false" aria-controls="admin_users">
              <i class="menu-icon mdi mdi-account-plus"></i>
              <span class="menu-title">Admin Users</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="admin_users">
              <ul class="nav flex-column sub-menu">
        <?php  if ( array_key_exists('users',$admin_user_perm) && $admin_user_perm['users']['view'] == 1 && $admin_user_perm['users']['allview'] == 1 ) { ?>
                <li class="nav-item"><a class="nav-link" href="<?php print base_url().'/admincp/users';?>">Users</a></li>
        <?php } ?>
        <?php  if ( array_key_exists('profiles',$admin_user_perm) && $admin_user_perm['profiles']['view'] == 1 && $admin_user_perm['profiles']['allview'] == 1 ) { ?>
                <li class="nav-item"><a class="nav-link" href="<?php print base_url().'/admincp/profiles';?>">Profiles</a></li>
        <?php } ?>
              </ul>
            </div>
          </li>
        <?php } ?>
        <?php  if ( array_key_exists('settings',$admin_user_perm) && $admin_user_perm['settings']['view'] == 1 && $admin_user_perm['settings']['allview'] == 1 ) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php print base_url().'/admincp/settings';?>">
              <i class="menu-icon mdi mdi-wrench"></i>
              <span class="menu-title">Settings</span>
            </a>
          </li>
        <?php } ?>
        </ul>
      </nav>