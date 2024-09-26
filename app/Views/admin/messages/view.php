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
              <label for="">Name: </label>
              <input type="text" readonly value="<?php print $record[0]['name'];?>" class="form-control">
              <label for="">Email:</label>
              <input type="text" readonly value="<?php print $record[0]['email'];?>" class="form-control">
              <label for="">Message: </label>
              <textarea readonly class="form-control"><?php print $record[0]['message'];?></textarea>

            </div>
          </div>

        </div>
      </div>

<!--     <div class="row">
        <div class="col">
          <div class="card card-small mb-4">
            <div class="card-header border-bottom">
              <h6 class="m-0 float-start" style="padding-top: 8px;">Message Reply</h6>
            <div class="clearfix"></div>
            </div>
            <div class="card-body p-0">

                <table class="table table-striped">
                  <tbody id="customerListTable">
                  <?php 
                    if(!empty($sql)){
                  ?>
                    <tr>
                          <td><?php print $sql['replymsg'];?></td>
                    </tr>
                  <?php
                    }
                  ?>  
                  </tbody>
                </table>

            </div>
          </div>

        </div>
      </div> -->


<?php print view('admin/footer');?>