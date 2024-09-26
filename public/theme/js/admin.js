var baseUrl;
var ValueUrl;

$(function(){

    $('#product-data').DataTable( {
        processing: true,
        // serverSide: true,
        ajax: baseUrl+'vendors/products/data',
        columns: [
            // { data: 'id' },
            {
              targets: 0,
              orderable: false,
              data: "id",
              render: function(data, type, row) {
                //use only `this` and change data to `data.cdId` this is for dmo only..
                return ("<input type='checkbox' id="+'checked_'+ data + " name='product-ids[]' value="+data+" class='checkAll'>")
              },
              className: "center"
            },
            { data: 'item_id' },
            { 
                data: 'name',
                render: function(data, type, row){
                    var st = data.split("__");
                    var html = '<div class="name-p d-flex align-items-center">\
                                    <div class="image">\
                                      <img src="'+st[1]+'" alt="">\
                                    </div>\
                                    <div class="name">'+st[0]+'</div>\
                                </div>';
                    return ( html );
                }  
            },
            { data: 'reference' },
            { data: 'category' },
            { 
                  data: 'price',
                  render: function(data, type, row){
                      return ( '<span>$ '+data+'</span>'); 
                  }  
            },
            { data: 'quantity' },
            { 
                data: 'status',
                render: function(data, type, row){
                    if ( data == 1 ) {
                        return ( '<span class="badge bg-success">Publish</span>');
                    } else {
                        return ( '<span class="badge bg-danger">Draft</span>');
                    }
                } 
            },
            { 
              data: 'edit',
              render: function(data, type, row){
                var st = data.split("__");
                var renderbtn = '<div class="action"><div class="btn-group" role="group">\
                    <button id="btnGroupDrop'+st[0]+'" type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">\
                                <svg id="Component_120_5" data-name="Component 120 – 5" xmlns="http://www.w3.org/2000/svg" width="19" height="5" viewBox="0 0 19 5">\
                              <g id="Group_315" data-name="Group 315">\
                                <circle id="Ellipse_34" data-name="Ellipse 34" cx="2.5" cy="2.5" r="2.5"/>\
                                <circle id="Ellipse_35" data-name="Ellipse 35" cx="2.5" cy="2.5" r="2.5" transform="translate(7)"/>\
                                <circle id="Ellipse_36" data-name="Ellipse 36" cx="2.5" cy="2.5" r="2.5" transform="translate(14)"/>\
                              </g>\
                            </svg>\
                            </button>\
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop'+st[0]+'">\
                                <li>\
                                  <a class="dropdown-item bbdr" href="'+baseUrl+'vendors/products/edit/'+st[0]+'">\
                                    <span class="icons"><i class="fa-solid fa-pencil"></i></span>\
                                    <span>Edit</span>\
                                  </a>\
                                </li>';
                  if ( st[1] == 1 ) {
                  renderbtn += '<li>\
                                  <a class="dropdown-item bbdr" href="'+baseUrl+'vendors/products/draft/'+st[0]+'">\
                                    <span class="icons"><i class="fa-brands fa-firstdraft"></i></span>\
                                    <span>Draft</span>\
                                  </a>\
                                </li>';
                  } else {
                  renderbtn += '<li>\
                                  <a class="dropdown-item bbdr" href="'+baseUrl+'vendors/products/publish/'+st[0]+'">\
                                    <span class="icons"><i class="fa-brands fa-firstdraft"></i></span>\
                                    <span>Publish</span>\
                                  </a>\
                                </li>';
                  }
                  renderbtn += '<li>\
                                  <a class="dropdown-item bbdr" onclick="return confirm(`Are you sure to delete this?`)" href="'+baseUrl+'vendors/products/trash/'+st[0]+'">\
                                    <span class="icons"><i class="fa-solid fa-trash"></i></span>\
                                    <span>Delete</span>\
                                  </a>\
                                </li>\
                            </ul>\
                    </div></div>';
                  return (renderbtn );
              }
            },
        ],
    } );

    $('#attributes-data').DataTable( {
        processing: true,
        // serverSide: true,
        ajax: baseUrl+'vendors/attributes/data',
        columns: [
            {
              targets: 0,
              orderable: false,
              data: "id",
              render: function(data, type, row) {
                //use only `this` and change data to `data.cdId` this is for dmo only..
                return ("<input type='checkbox' id="+'checked_'+ data + " name='attributes-ids[]' value="+data+" class='checkAll'>")
              },
              className: "center"
            },
            { 
                data: 'name',
                render: function(data, type, row){
                    var html = '<div class="namebb d-flex">'+data+'</div>';
                    return ( html );
                }  
            },
            { 
                data: 'value',
                render: function(data, type, row){
                    var html = '<div class="namebb d-flex">'+data+'</div>';
                    return ( html );
                }  
            },
            { 
              data: 'edit',
              render: function(data, type, row){
                var st = data.split("__");
                var renderbtn = '<div class="action"><div class="btn-group" role="group">\
                    <button id="btnGroupDrop'+data+'" type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">\
                                <svg id="Component_120_5" data-name="Component 120 – 5" xmlns="http://www.w3.org/2000/svg" width="19" height="5" viewBox="0 0 19 5">\
                              <g id="Group_315" data-name="Group 315">\
                                <circle id="Ellipse_34" data-name="Ellipse 34" cx="2.5" cy="2.5" r="2.5"/>\
                                <circle id="Ellipse_35" data-name="Ellipse 35" cx="2.5" cy="2.5" r="2.5" transform="translate(7)"/>\
                                <circle id="Ellipse_36" data-name="Ellipse 36" cx="2.5" cy="2.5" r="2.5" transform="translate(14)"/>\
                              </g>\
                            </svg>\
                            </button>\
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop'+st[0]+'">\
                                <li>\
                                  <a class="dropdown-item bbdr" href="'+baseUrl+'vendors/attributes/edit/'+st[0]+'">\
                                    <span class="icons"><i class="fa-solid fa-pencil"></i></span>\
                                    <span>Edit</span>\
                                  </a>\
                                </li>\
                                <li>\
                                  <a class="dropdown-item bbdr" onclick="return confirm(`Are you sure to delete this?`)" href="'+baseUrl+'vendors/attributes/edit/'+st[0]+'">\
                                    <span class="icons"><i class="fa-solid fa-trash"></i></span>\
                                    <span>Delete</span>\
                                  </a>\
                                </li>\
                                <li>\
                                  <a class="dropdown-item bbdr" href="'+baseUrl+'vendors/attributes/values/'+st[0]+'/?t='+st[1]+'">\
                                    <span class="icons"><i class="fa-solid fa-plus"></i></span>\
                                    <span>Add Value</span>\
                                  </a>\
                                </li>\
                            </ul>\
                    </div></div>';
                  return (renderbtn );
              }
            },
        ],
    } );

    $('#attributes-value-data').DataTable( {
        processing: true,
        // serverSide: true,
        ajax: baseUrl+'vendors/attributes/valuesdata/'+ValueUrl,
        columns: [
            {
              targets: 0,
              orderable: false,
              data: "id",
              render: function(data, type, row) {
                //use only `this` and change data to `data.cdId` this is for dmo only..
                return ("<input type='checkbox' id="+'checked_'+ data + " name='value-ids[]' value="+data+" class='checkAll'>")
              },
              className: "center"
            },
            { 
                data: 'name',
                render: function(data, type, row){
                    var html = '<div class="namebb d-flex">'+data+'</div>';
                    return ( html );
                }  
            },
            { 
                data: 'value_opt',
                render: function(data, type, row){
                    var html = '<div class="namebb d-flex">'+data+'</div>';
                    return ( html );
                }  
            },
            { 
              data: 'edit',
              render: function(data, type, row){
                var st = data.split("__");
                var renderbtn = '<div class="action"><div class="btn-group" role="group">\
                    <button id="btnGroupDrop'+st[0]+'" type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">\
                                <svg id="Component_120_5" data-name="Component 120 – 5" xmlns="http://www.w3.org/2000/svg" width="19" height="5" viewBox="0 0 19 5">\
                              <g id="Group_315" data-name="Group 315">\
                                <circle id="Ellipse_34" data-name="Ellipse 34" cx="2.5" cy="2.5" r="2.5"/>\
                                <circle id="Ellipse_35" data-name="Ellipse 35" cx="2.5" cy="2.5" r="2.5" transform="translate(7)"/>\
                                <circle id="Ellipse_36" data-name="Ellipse 36" cx="2.5" cy="2.5" r="2.5" transform="translate(14)"/>\
                              </g>\
                            </svg>\
                            </button>\
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop'+st[0]+'">\
                                <li>\
                                  <a class="dropdown-item bbdr" href="'+baseUrl+'vendors/attributes/valueedit/'+st[0]+'/'+st[1]+'/?t='+st[2]+'">\
                                    <span class="icons"><i class="fa-solid fa-pencil"></i></span>\
                                    <span>Edit</span>\
                                  </a>\
                                </li>\
                                <li>\
                                  <a class="dropdown-item bbdr" onclick="return confirm(`Are you sure to delete this?`)" href="'+baseUrl+'vendors/attributes/valuetrash/'+st[0]+'/'+st[1]+'/?t='+st[2]+'">\
                                    <span class="icons"><i class="fa-solid fa-trash"></i></span>\
                                    <span>Delete</span>\
                                  </a>\
                                </li>\
                            </ul>\
                    </div></div>';
                  return (renderbtn );
              }
            },
        ],
    } );

	$('#addGallery').click(function(){
        $('.loader').show();
        $.get( baseUrl+"vendors/media/gallery?page=1", function( data ) {
            var r = JSON.parse(data);
            if ( r == null ) {
                $('#galleryBlock #gbb').html('<div class="col-12 mt-4"><p class="alert alert-danger">No files uploaded</p></div>');
                $('#galModal').modal('show');
                // uploadGallery();
            } else {
                if ( $('.gallery-cols').length > 0 ) {
                    $('#galleryBlock #gbb .col-md-2').remove();
                }
               $.each( r , function(index , value){
                  var html = '<div class="col-md-2 mt-3 mb-2">\
                                <div class="gallery-cols" id="gallery_cols_'+value.id+'" onclick="selectGallery('+value.id+');" data-thumb="'+value.small+'" data-img="'+value.image+'">\
                              <img src="'+value.medium+'" alt="" class="rounded" style="height: 100px; width: 100%; object-fit: cover; object-position: center; cursor:pointer;">\
                             </div></div>';
                  $('#galleryBlock #gbb').append(html);
               });
               $('#galModal').modal('show');
            }
            // console.log('data',r);
            $('.loader').hide();
        });
    });

    $('#addImage').click(function() {
      let galleryTypeSingle = $('#galleryTypeSingle').length;
      // $('.loader').show();
      var active_img = $('.active_img').length;
      if (active_img > 0) {
        var images = [];
        $(".active_img").each(function() {
          images.push($(this).attr('id'));
        });
        // alert( $('.ppgal').length );
        if ($('.ppgal').length > 0 && !galleryTypeSingle) {
          // $('#product_image_block .col-md-2').remove();
          // $('#inputHidden input').remove();
          var ll = parseInt($('.ppgal').length) + 1;
          $.each(images, function(index, value) {
            var fullimg = $('#' + value).attr('data-thumb');
            var fullimgname = $('#' + value).attr('data-img');
            var checkoldimg = $('#input_pp_' + value).val();
            if (checkoldimg == fullimgname) {
  
            } else {
              var htmlfullimg = '<div class="col-md-3 mt-1 mb-1 pp_' + ll + '"><div class="position-relative">\
                                            <div class="delicon btn btn-danger" style="position: absolute;padding: 3px;" onclick="removePImg(' + ll + ');"><i class="fa-regular fa-trash-can"></i></div>\
                                            <div class="ppgal" onclick=assignCover("' + fullimgname + '",' + ll + ')>\
                                              <img src="' + fullimg + '" alt="" class="rounded" style="height: 100px; width: 100%; object-fit: cover; object-position: center; cursor:pointer;">\
                                            </div>\
                                        </div></div>';
              $('#product_image_block').prepend(htmlfullimg);
              $('#inputHidden').append('<input type="hidden" id="input_pp_' + ll + '" name="product_gallery[]" value="' + fullimgname + '" />');
            }
            ll++;
          });
        } else {
          var ll = 1;
          $.each(images, function(index, value) {
            var fullimg = $('#' + value).attr('data-thumb');
            var fullimgname = $('#' + value).attr('data-img');
            var htmlfullimg = `<div class="col-md-3 mt-1 mb-1 pp_${ll}'"><div class="position-relative">
            ${galleryTypeSingle ? '' : `<div class="delicon btn btn-danger" style="position: absolute;padding: 3px;" onclick="removePImg(${ll});"><i class="fa-regular fa-trash-can"></i></div>`}
            <div ${galleryTypeSingle ? '' : `class="ppgal" onclick=assignCover("${fullimgname}",${ll})`} >
                                                <img src="${fullimg}" alt="" class="rounded" style="height: 100px; width: 100%; object-fit: cover; object-position: center; cursor:pointer;">
                                              </div>
                                          </div></div>${galleryTypeSingle ? `<input type="hidden" id="input_pp_'${ll}" name="fimg" value="${fullimgname}" />` : ''}`;
            if(galleryTypeSingle) {
              let productImages = $('#product_image_block').find('div.col-md-3');
              $.each(productImages, function() {
                if(!$(this).find('#addGallery').length) {
                  $(this).remove();
                }
              });
            }
            $('#product_image_block').prepend(htmlfullimg);
            if(!galleryTypeSingle) {
              $('#inputHidden').append('<input type="hidden" id="input_pp_' + ll + '" name="product_gallery[]" value="' + fullimgname + '" />');
            }
            ll++;
          });
        }
        $('#galModal').modal('hide');
        $('.loader').hide();
      } else {
        alert('Select Images');
      }
    });

	$("#draganddropzoneGallery").dmUploader({
        url: baseUrl+'vendors/media/upload',
        //... More settings here...
        headers: {
           'X-CSRF-TOKEN': $('#mediaGalleryUpload').val()
        },
        maxFileSize: 3000000, // 3 Megs 
        allowedTypes: "image/*",
        extFilter: ["jpg", "jpeg", "png"],
        onDragEnter: function(){
          // Happens when dragging something over the DnD area
          this.addClass('active');
        },
        onDragLeave: function(){
          // Happens when dragging something OUT of the DnD area
          this.removeClass('active');
        },
        onInit: function(){
          // Plugin is ready to use
          ui_add_log('Penguin initialized :)', 'info');
        },
        onComplete: function(){
          // All files in the queue are processed (success or error)
          $('#myTab #galleryBlock-tab').tab('show');
          ui_add_log('All pending tranfers finished');
        },
        onNewFile: function(id, file){
          // When a new file is added using the file selector or the DnD area
          ui_add_log('New file added #' + id);
          ui_multi_add_file(id, file);
        },
        onBeforeUpload: function(id){
          // about tho start uploading a file
          ui_add_log('Starting the upload of #' + id);
          ui_multi_update_file_status(id, 'uploading', 'Uploading...');
          ui_multi_update_file_progress(id, 0, '', true);
        },
        onUploadCanceled: function(id) {
          // Happens when a file is directly canceled by the user.
          ui_multi_update_file_status(id, 'warning', 'Canceled by User');
          ui_multi_update_file_progress(id, 0, 'warning', false);
        },
        onUploadProgress: function(id, percent){
          // Updating file progress
          ui_multi_update_file_progress(id, percent);
        },
        onUploadSuccess: function(id, data){
          var paths = JSON.parse(data);
          // A file was successfully uploaded
          // ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
          // ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
          // ui_multi_update_file_status(id, 'success', 'Upload Complete');
          ui_multi_update_file_progress(id, 100, 'success', false);
          $('#mediaGalleryUpload').val(data.csrf_token);

          var html = '<div class="col-md-2 mt-3 mb-2">\
                        <div class="gallery-cols active_img" id="gallery_cols_'+paths.id+'" onclick="selectGallery('+paths.id+');" data-thumb="'+paths.small+'" data-img="'+paths.path+'">\
                      <img src="'+paths.medium+'" alt="" class="rounded" style="height: 100px; width: 100%; object-fit: cover; object-position: center; cursor:pointer;">\
                     </div></div>';
          $('#galleryBlock #gbb').prepend(html);
          // $('#myTab #galleryBlock-tab').tab('show');
          $('.alert-danger').hide();
          $('.productGal').append('<input type="hidden" name="product_gallery[]" value="'+paths.path+'"/>');
          // console.log(html);
        },
        onUploadError: function(id, xhr, status, message){
          ui_multi_update_file_status(id, 'danger', message);
          ui_multi_update_file_progress(id, 0, 'danger', false);  
          // $('input[name=csrf_test_name]').val(xhr.csrf_token);
        },
        onFallbackMode: function(){
          // When the browser doesn't support this plugin :(
          ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
        },
        onFileSizeError: function(file){
          ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
        }
        
    });

    $(function(){
      $('#value_opt').on('change',function(){
        var value_opt = $(this).val();
        if ( value_opt == 1 ) {
          $('#color_value').hide();
          $('#text_value').show();
        } else if ( value_opt == 2 ) {
          $('#color_value').show();
          $('#text_value').hide();
        } else {
          $('#color_value').hide();
          $('#text_value').hide();
        }
      });
    });

    $('#relatedProduct').click(function(){
        $('#relatedProduct').hide();
        $('#adminRelatedSection').show();
    });

    
});

function uploaddesign(uploadDesign,field)
{
    $("#"+uploadDesign).dmUploader({
        url: baseUrl+'vendors/design/upload',
        //... More settings here...
        headers: {
           'X-CSRF-TOKEN': $('#_tt_cc').val()
        },
        multiple: false,
        maxFileSize: 20000000, // Max upload banner
        allowedTypes: "image/*",
        extFilter: ["jpg", "jpeg", "png"],
        onDragEnter: function(){
          // Happens when dragging something over the DnD area
          this.addClass('active');
        },
        onDragLeave: function(){
          // Happens when dragging something OUT of the DnD area
          this.removeClass('active');
        },
        onInit: function(){
          // Plugin is ready to use
          ui_add_log('Penguin initialized :)', 'info');
        },
        onComplete: function(){
          // All files in the queue are processed (success or error)
          // $('#myTab #galleryBlock-tab').tab('show');
            $('.loader').hide();
          ui_add_log('All pending tranfers finished');
        },
        onNewFile: function(id, file){
          // When a new file is added using the file selector or the DnD area
          ui_add_log('New file added #' + id);
          ui_multi_add_file(id, file);
        },
        onBeforeUpload: function(id){
            $('.loader').show();
          // about tho start uploading a file
          ui_add_log('Starting the upload of #' + id);
          ui_multi_update_file_status(id, 'uploading', 'Uploading...');
          ui_multi_update_file_progress(id, 0, '', true);
        },
        onUploadCanceled: function(id) {
          // Happens when a file is directly canceled by the user.
          ui_multi_update_file_status(id, 'warning', 'Canceled by User');
          ui_multi_update_file_progress(id, 0, 'warning', false);
        },
        onUploadProgress: function(id, percent){
          // Updating file progress
          ui_multi_update_file_progress(id, percent);
        },
        onUploadSuccess: function(id, data){
          var paths = JSON.parse(data);
          // A file was successfully uploaded
          // ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
          // ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
          // ui_multi_update_file_status(id, 'success', 'Upload Complete');
          ui_multi_update_file_progress(id, 100, 'success', false);
          $('#'+uploadDesign).css("background-image", "url(\""+ paths.medium +"\")");
          $('#'+uploadDesign+' .grids').remove();
          $('#'+uploadDesign+' .changebg').removeClass('d-none');
          // console.log(paths);
        },
        onUploadError: function(id, xhr, status, message){
          ui_multi_update_file_status(id, 'danger', message);
          ui_multi_update_file_progress(id, 0, 'danger', false);  
          // $('input[name=csrf_test_name]').val(xhr.csrf_token);
        },
        onFallbackMode: function(){
          // When the browser doesn't support this plugin :(
          ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
        },
        onFileSizeError: function(file){
          alert('File \'' + file.name + '\' Cannot be added: Maximum 20MB file allow to upload');
        },
        extraData: {
           "field": field
        }
        
    });
}

function selectVendorCat(catid,activelink,catetitle,valuetitle)
{
    $('#selectblock').val(catid);
    $('#selecttitle').val(catetitle);
    $('#catetitle').val(valuetitle);
    $('#vcat option[value="'+activelink+'"]').attr("selected", "selected");
    $('#vendorCatModal').modal('show');
}

function updateVendorCat()
{
    $('.loader').show();
    var selectCat = $('#vcat').val();
    var selectblock = $('#selectblock').val();
    var selecttitle = $('#selecttitle').val();
    var catetitle = $('#catetitle').val();
    if ( catetitle == "" ) {
        $('.loader').hide();
        alert('Please add title');
    } else {
        $.ajax({
            url: baseUrl + "vendors/design/status",
            type:"POST",
            data: { 'selectblock': selectblock, 'selectCat': selectCat, 'selecttitle': selecttitle, 'catetitle': catetitle },
            dataType:"json",
            success: function(resp){
                $('.loader').hide();
                if ( resp.status == 'ok' ) {
                    $('#vendorCatModal').modal('hide');
                }
           }
        });
    }
}

function updateOrderStatus(ids,oid)
{
    $('.loader').show();
    var ship = $("#status_"+ids).val();
    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('#_tt_cc').val());
        }
    });
    $.ajax({
        url: baseUrl + "vendors/orders/status",
        type:"POST",
        data: { ship: ship, oid: oid , ids: ids },
        dataType:"json",
        success: function(resp){
            $('#_tt_cc').val(resp.token);
            $('.loader').hide();
       }
    });
}

function updateFinalPrice()
{
    var p_deal_enable = $('#p_deal_enable').is(':checked');
    var p_deal_price = $('#p_deal_price').val();
    var p_regular_price = $('#p_regular_price').val();
    var commission = $('#p_final_price').data('commission');
    var commission_option = $('#p_final_price').data('commission-option');
    var commission_status = $('#p_final_price').data('commission-status');
    var commission_price = $('#p_final_price').data('commission-price');
    if ( p_deal_enable == true ) {
        if ( commission_status == 1 ) {
            if ( commission_option == 1 ) {
                if ( commission_price == 1 ) {
                    var final_price = (parseFloat(p_deal_price) + parseFloat(commission)).toFixed(2);
                    var default_regular_price = (parseFloat(p_regular_price) + parseFloat(commission)).toFixed(2);
                    $('#deal_final_price').val(parseFloat(p_deal_price) + parseFloat(commission));
                    $('#p_final_price').val(final_price);
                    $('#default_final_price').val(default_regular_price);
                    $('#p_zappta_commission').val(commission);
                } else {
                    var final_price = ( parseFloat(p_deal_price) ).toFixed(2);
                    var default_regular_price = (parseFloat(p_regular_price)).toFixed(2);
                    $('#deal_final_price').val(p_deal_price);
                    $('#p_final_price').val(final_price);
                    $('#default_final_price').val(default_regular_price);
                    $('#p_zappta_commission').val(commission);
                }
            } 
        } else {
            // var final_price = (parseFloat(p_deal_price)).toFixed(2);
            // $('#p_final_price').val(final_price);
            var final_price = (parseFloat(p_deal_price)).toFixed(2);
            var default_regular_price = (parseFloat(p_regular_price)).toFixed(2);
            $('#deal_final_price').val(parseFloat(p_deal_price));
            $('#p_final_price').val(final_price);
            $('#default_final_price').val(default_regular_price);
            // $('#p_zappta_commission').val(commission);
        }
    } else {
        // console.log('p_regular_price', p_regular_price);
        if ( commission_status == 1 ) {
            if ( commission_option == 1 && commission_price == 1 ) {
                if ( parseFloat(p_regular_price) > 0 ) {
                    var final_prices = (parseFloat(p_regular_price) + parseFloat(commission)).toFixed(2);
                    $('#p_final_price').val(final_prices);
                    $('#default_final_price').val(final_prices);
                    $('#p_zappta_commission').val(commission);
                // alert(final_prices);
                }
            }
        } else {
            if ( parseFloat(p_regular_price) > 0 ) {
                var final_prices = (parseFloat(p_regular_price)).toFixed(2);
                $('#p_final_price').val(final_prices);
                $('#default_final_price').val(final_prices);
            }
        }
    }
}

function formatRepo (repo) {
    console.log(repo);
    if (repo.loading) {
        return repo.text;
    }

    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='" + repo.image + "' /></div>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'></div>" +
          "</div>" +
        "</div>" +
      "</div>"
    );

    $container.find(".select2-result-repository__title").text(repo.text);

    return $container;
}

function formatRepoSelection (repo) {
    return repo.text;
}

function assignCover(name,ids)
{
    $('#productCover').val(name);
    $('#product_image_block .col-md-3').removeClass('active-cover');
    $('.pp_'+ids).addClass('active-cover');
}

function getCheckBox(ids)
{
    var values = $('#'+ids).is(':checked');
    if ( values ) {
        $('#priceblock').show();
    } else {
        $('#priceblock').hide();
    }
}

function setTextColor(picker) {
  //document.getElementsByTagName('body')[0].style.color = '#' + picker.toString()
}

function removePImg(value)
{
    $('.pp_'+value).remove();
    $('#input_pp_'+value).remove();
}

function selectGallery(id)
{
    if ( $( '#gallery_cols_'+id ).hasClass('active_img') ) {
        $( '#gallery_cols_'+id ).removeClass('active_img');
    } else {
        $('#gallery_cols_'+id).addClass('active_img');
    }
}

function delete_attr_img(ids)
{
    $('#filenamevalue').val('');
    $('#attr_value_img_block').remove();
}

function getFilename(ids,postid)
{
    var file = $('#'+ids).get(0).files[0];
    let img = new Image()
    img.src = window.URL.createObjectURL(file);
    img.onload = () => {
        if(img.width <= 200 && img.height <= 200){
            $('#'+postid).text(file.name);
            // alert(`Nice, image is the right size. It can be uploaded`)
            // upload logic here
        } else {
            document.querySelector('#'+ids).value = '';
            alert(`Sorry, this image doesn't look like the size we wanted. It's ${img.width} x ${img.height} but we require 100 x 100 size image.`);
        }                
    }
}

function getStoreLogo(ids,postid)
{
    var file = $('#'+ids).get(0).files[0];
    let img = new Image()
    img.src = window.URL.createObjectURL(file);
    img.onload = () => {
        if(img.width <= 1000 && img.height <= 1000){
            $('#'+postid).text(file.name);
            // alert(`Nice, image is the right size. It can be uploaded`)
            // upload logic here
        } else {
            document.querySelector('#'+ids).value = '';
            alert(`Sorry, this image doesn't look like the size we wanted. It's ${img.width} x ${img.height} but we require 300px x 300px size image.`);
        }                
    }
}



tinymce.init({
    selector: 'textarea.tinymce',  // change this value according to your HTML
    theme : "advanced",
    plugins : "jbimages,autolink,lists,pagebreak,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
    // Theme options
    theme_advanced_buttons1 : "jbimages,image,|,save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    relative_urls: false,
    remove_script_host: false,
    allow_conditional_comments: true,
    schema: 'html5'
});

$.sidebarMenu = function(menu) {
  var animationSpeed = 300;
  $(menu).on('click', 'li a', function(e) {
    var $this = $(this);
    var checkElement = $this.next();

    if (checkElement.is('.treeview-menu') && checkElement.is(':visible')) {
      checkElement.slideUp(animationSpeed, function() {
        checkElement.removeClass('menu-open');
      });
      checkElement.parent("li").removeClass("active");
    }

    //If the menu is not visible
    else if ((checkElement.is('.treeview-menu')) && (!checkElement.is(':visible'))) {
      //Get the parent menu
      var parent = $this.parents('ul').first();
      //Close all open menus within the parent
      var ul = parent.find('ul:visible').slideUp(animationSpeed);
      //Remove the menu-open class from the parent
      ul.removeClass('menu-open');
      //Get the parent li
      var parent_li = $this.parent("li");

      //Open the target menu and add the menu-open class
      checkElement.slideDown(animationSpeed, function() {
        //Add the class active to the parent li
        checkElement.addClass('menu-open');
        parent.find('li.active').removeClass('active');
        parent_li.addClass('active');
      });
    }
    //if this isn't a link, prevent the page from being redirected
    if (checkElement.is('.treeview-menu')) {
      e.preventDefault();
    }
  });
}

$.sidebarMenu($('.sidebar-menu'))


var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
