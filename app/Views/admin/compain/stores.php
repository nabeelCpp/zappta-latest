<?php print view('admin/header'); ?>

<div class="row">
  <div class="col" id="alert-message"><?php print show_message(); ?></div>
</div>

<div class="row">
  <div class="col">
    <div class="card card-small mb-4">
      <div class="card-header border-bottom">
        <h6 class="m-0 float-start" style="padding-top: 8px;">Store Sprees</h6>
        <div class="clearfix"></div>
      </div>
      <div class="card-body p-0">

        <table class="table table-striped table-bordered" id="spreeTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Spree Image</th>
              <th>Spree Price</th>
              <th>Created at</th>
              <th>Status</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody id="customerListTable">
            <?php if (is_array($sprees) && count($sprees) > 0) {
              $itme = 1;
              foreach ($sprees as $pro) {
                if (! empty($pro['cover'])) {
                  $ext_name = explode('.', $pro['cover']);
                  $url = base_url() . '/upload/media/spree/' . $pro['cover'];
                } else {
                  $url = base_url() . '/images/product/img-not-found/jpg/100';
                } ?>
                <tr>
                  <!-- <td><input type="checkbox" name="product-ids[]" value="<?php print my_encrypt($pro['id']); ?>" /></td> -->
                  <td><?php print $itme; ?></td>
                  <td>
                    <div class="name-p d-flex align-items-center">
                      <div class="image">
                        <img src="<?php print $url; ?>" alt="">
                      </div>
                    </div>
                  </td>
                  <td><?php print $pro['price']; ?></td>
                  <td><?php print date('m/d/Y', strtotime($pro['created_at'])); ?></td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" style="margin-left: 0px !important;" type="checkbox" role="switch" onchange="changeStatus(<?= $pro['id'] ?>,<?= $pro['status'] ?>, this)" <?= $pro['status'] ? 'checked' : '' ?>>
                    </div>
                  </td>
                  <td>
                    <div class="action">
                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop<?php print my_encrypt($pro['id']); ?>" type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                          <svg id="Component_120_5" data-name="Component 120 – 5" xmlns="http://www.w3.org/2000/svg" width="19" height="5" viewBox="0 0 19 5">
                            <g id="Group_315" data-name="Group 315">
                              <circle id="Ellipse_34" data-name="Ellipse 34" cx="2.5" cy="2.5" r="2.5" />
                              <circle id="Ellipse_35" data-name="Ellipse 35" cx="2.5" cy="2.5" r="2.5" transform="translate(7)" />
                              <circle id="Ellipse_36" data-name="Ellipse 36" cx="2.5" cy="2.5" r="2.5" transform="translate(14)" />
                            </g>
                          </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop<?php print my_encrypt($pro['id']); ?>">
                          <li>
                            <a class="dropdown-item bbdr" onclick="return confirm(`Are you sure to delete this?`)" href="<?php print base_url(); ?>/admincp/compain/trashSpree/<?php print my_encrypt($pro['id']); ?>">
                              <span class="icons"><i class="fa-solid fa-trash"></i></span>
                              <span>Delete</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
            <?php
                $itme++;
              }
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<?php print view('admin/footer'); ?>
<script>
  function changeStatus(id, status, _this) {
    let tr = $(_this).parents('tr');
    tr.css('opacity', '0.5');
    tr.css('pointer-events', 'none');
    let meta = $('meta[name=csrf-token]');
    let csrf_token = meta.attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': csrf_token
      }
    });
    $.ajax({
      url: '/admincp/compain/spreeStatus',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
        status: status
      },
      success: function(response) {
        tr.removeAttr('style');
        meta.attr('content', response.csrf_token);
        $(_this).removeAttr('onclick');
        $(_this).attr('onclick', `changeStatus(${id}, ${status?0:1}, this)`);
        let message = `<div class="alert alert-success"><strong>${response.message}</strong></div>`;
        $('#alert-message').html(message);
        setTimeout(() => {
          $('#alert-message').html('');
        }, 5000);
      }
    })
  }

  new DataTable('#spreeTable');
</script>