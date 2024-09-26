<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row mb-4">
            <div class="col-12" id="emailerrors"></div>
        </div>

        <form id="emailSendForm">
                  
            <div class="row">
                  <div class="col">
                    <div class="card card-small mb-4">
                      <div class="card-header border-bottom">
                          <h6 class="m-0 float-start" style="padding-top: 8px;">Stores Email</h6>
                          <button type="button" id="sendEmail" class="btn btn-primary btn-sm float-end">Send Selected</button>
                    	   <div class="clearfix"></div>
                      </div>
                      <div class="card-body p-0">
                      		<table class="table table-striped">
                      			<thead>
                      				<tr>
                      					  <th width="50"><input type="checkbox" id="allemail" name="checkAll"></th>
    		                          <th>Name</th>
    		                          <th>Email</th>
                                  <th>Status</th>
                                  <th>Total Products</th>
                      				</tr>
                      			</thead>
                      			<tbody id="customerListTable">
                      			<?php 
                      				if(is_array($sql)){
                      					$sr = 1;
                      					foreach($sql as $row){
                      			?>
                      				<tr>
                      							<td><input type="checkbox" class="singleemail" name="check" value="<?php print $row['email'];?>"></td>
                                		<td><?php print $row['store_name'];?></td>
    		                            <td><?php print $row['email'];?></td>
                      				      <td></td>
                                    <td></td>
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
                  </div>
                </div>
        </form>
<style>
#myProgress {
  width: 100%;
  height: 20px;
  position: relative;
  background-color: #ddd;
}

#myBar {
  background-color: #4CAF50;
  width: 0px;
  height: 20px;
  position: absolute;
  text-align: center;
}
</style>
<div class="modal fade" id="emailLoader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <div id="myProgress">
            <div id="myBar"></div>
          </div>
      </div>
    </div>
  </div>
</div>
            
<script type="text/javascript">
    $(function(){
        $('#sendEmail').click(function(){
            var total_email = $('.singleemail:checked').length;
            var emaillist = [];
            if ( total_email === 0 ) {
                $('#emailerrors').html('<p class="alert alert-danger">Please select atleast one email</p>');
                setTimeout(function(){
                    $('#emailerrors p').remove();
                }, 5000);
            } else {
              $.each( $('.singleemail:checked') , function() {
                  emaillist.push($(this).val());
              } );
              var sum = 0;
              $('#emailLoader').modal('show');
              var postdata = setInterval(postEmail,5000);
              function postEmail()
              {
                  if ( sum == total_email ) {
                      clearInterval(postdata);
                      $('#emailLoader').modal('hide');
                  } else {
                      var widths = (( 100 * ( sum + 1 ) ) / total_email).toFixed(2);
                      $('#myBar').css('width',widths+'%');
                      $('#myBar').text(widths+'%');
                      $.ajax({
                          url: '<?php print base_url().'/admincp/compain/emailsent';?>',
                          type: 'post',
                          data: { email: emaillist[ sum ] , compaign_id: '<?php print $c_id;?>' },
                          // datatype: 'JSON',
                          success: function(resp)
                          {
                            // console.log('resp',resp);
                          }
                      });
                      sum++;
                  }
              }
            }
        });
    });
</script>  
<script type="text/javascript">
  $('[name="checkAll"]').click(function(){
    let checkall = $(this);
    let checks = $('[name="check"]');
    checks.each(function(){
      if($(this).is(':checked') && checkall.is(':checked')){
        $(this).prop('checked', false);
      }

      if(!$(this).is(':checked') && !checkall.is(':checked')){
        $(this).prop('checked', true);
      }
      $(this).click();
    })
  });
 
</script>          
<?php print view('admin/footer');?>