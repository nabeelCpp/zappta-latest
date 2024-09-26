<?php print view('admin/header');?>
  
    <div class="row">
      <div class="col"><?php print show_message();?></div>
    </div>

    <div class="row">
        <div class="col">
          <div class="card card-small mb-4">
            <div class="card-header border-bottom">
              <h6 class="m-0 float-start" style="padding-top: 8px;">Messages</h6>
            <div class="clearfix"></div>
            </div>
            <div class="card-body p-0">

                <table class="table table-striped">
                  <thead>
                    <tr>
                          <th width="80"></th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Message</th>
                          <th></th>
                    </tr>
                  </thead>
                  <tbody id="customerListTable">
                  <?php 
                    if(is_array($name)){
                      $sr = 1;
                      foreach($name as $row){
                  ?>
                    <tr>
                          <td><?php print $row['id'];?></td>
                          <td>
                              <p><?php print $row['name'];?></p>

                          </td>
                          <td>
                            <p><?php print $row['email'];?></p>
                          </td>
                          <td>
                              <p><?php print short($row['message'],20);?></p>
                          </td>
                          <td>
                              <a href="<?php print base_url().'/admincp/messages/view/'.$row['id'];?>" class="badge badge-success text-decoration-none">View</a>
                              <a href="<?php print base_url().'/admincp/messages/delete/'.$row['id'];?>" onclick="return confirm('Are you sure to delete this?');" class="badge badge-danger text-decoration-none">Delete</a>
                          </td>
                    </tr>
                  <?php
                        $sr++;
                      }
                    }
                  ?>  
                  </tbody>
                </table>

            </div>
          </div>
             <?php if ( $total_result > 14 ) { ?>
            <div class="pagenation">
              <?php print $pager->makeLinks(1, 20, $total_result,'front_full') ?>
            </div>
          <?php } ?>
                </div>
      </div>


<?php print view('admin/footer');?>