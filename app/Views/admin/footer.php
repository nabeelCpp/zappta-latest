</div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2022. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?php print base_url() . ADMIN;?>/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- <script src="<?php print base_url() . ADMIN;?>/vendors/chart.js/Chart.min.js"></script> -->
  <script src="<?php print base_url() . ADMIN;?>/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/vendors/progressbar.js/progressbar.min.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/vendors/select2/select2.min.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/vendors/jquery-asColor/jquery-asColor.min.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/vendors/jquery-asGradient/jquery-asGradient.min.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/vendors/jquery-asColorPicker/jquery-asColorPicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?php print base_url() . ADMIN;?>/js/off-canvas.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/hoverable-collapse.js"></script>
  <!-- <script src="<?php print base_url() . ADMIN;?>/js/template.js"></script> -->
  <script src="<?php print base_url() . ADMIN;?>/js/settings.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php print base_url() . ADMIN;?>/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/dashboard.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/Chart.roundedBarCharts.js"></script>
  <script src="<?php print base_url() . ADMIN;?>/js/select2.js"></script>
<!-- <script type="text/javascript" src="<?php print base_url() . ADMIN;?>/tiny_mce/tiny_mce.js"></script> -->
  <!-- End custom js for this page-->
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    // tinymce.init({
    //   selector: '.tinymce',
    //   plugins: [
    //       'advlist autolink link image lists charmap print preview hr anchor pagebreak',
    //       'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
    //       'table emoticons template paste help'
    //     ],
    //     toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
    //       'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
    //       'forecolor backcolor emoticons | help',
    //     menu: {
    //       favs: {title: 'My Favorites', items: 'code visualaid | searchreplace'}
    //     },
    //     menubar: 'favs file edit view insert format tools table help'
    // });
    $(document).ready(function(){
       tinymce.init({
        selector: '.tinymce',
        height: 500,
        plugins: [
          'advlist autolink link image lists charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
          'table emoticons template paste help'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
          'forecolor backcolor emoticons | help',
        menubar: 'file edit view insert format tools table help'
      });
    })
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript">

      // tinymce.init({
      //   selector: 'textarea.tinymce',  // change this value according to your HTML
      //   theme : "advanced",
      //   plugins : "jbimages,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

      //   // Theme options
      //   theme_advanced_buttons1 : "jbimages,|,save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
      //   theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
      //   theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
      //   theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
      //   theme_advanced_toolbar_location : "top",
      //   theme_advanced_toolbar_align : "left",
      //   theme_advanced_statusbar_location : "bottom",
      //   theme_advanced_resizing : true,

      //     // ===========================================
      //     // Set RELATIVE_URLS to FALSE (This is required for images to display properly)
      //     // ===========================================
         
      //   relative_urls: false,
      //   remove_script_host: false,
      //   allow_conditional_comments: true,
      //   schema: 'html5'
      // });


      (function($) {
        'use strict';
        $(function() {
          $('.file-upload-browse').on('click', function() {
            var file = $(this).parent().parent().parent().find('.file-upload-default');
            file.trigger('click');
          });
          $('.file-upload-default').on('change', function() {
            $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
          });

          if ($(".color-picker").length) {
            $('.color-picker').asColorPicker();
          }
          
        });
      })(jQuery);

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

      function delete_attr_img(ids)
      {
          $('#filenamevalue').val('');
          $('#attr_value_img_block').remove();
      }

      $('.searchBrandFilter').select2({
          placeholder: "Search Brand",
          ajax: {
              url: "<?php print base_url().'/admincp/categories/getajaxbrand';?>",
              type: "POST",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                  return {
                      search: params.term // search term
                  };
              },
              processResults: function (response) {
                  return {
                      results: response
                  };
              },
              cache: false
          }
      });

      $('.searchAttributesFilter').select2({
          placeholder: "Search Attributes",
          ajax: {
              url: "<?php print base_url().'/admincp/categories/getajaxattributes';?>",
              type: "POST",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                  return {
                      search: params.term // search term
                  };
              },
              processResults: function (response) {
                  return {
                      results: response
                  };
              },
              cache: false
          }
      });

  </script>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
</body>
</html>