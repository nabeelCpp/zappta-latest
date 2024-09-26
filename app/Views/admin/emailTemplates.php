<?php print view('admin/header');?>
	<div class="container">
		<button type="btn btn-primary" id="addTpl"><i class="fa fa-add"></i>Add Template</button>
		<div class="row" id="templatesContiainer">
			
		</div>
	</div>

<?php print view('admin/footer');?>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script>
		function initializeTinymce(id) {
		  tinymce.init({
		    selector: '#mytextarea_'+id,
		    height: 500,
		    plugins: [
		      'advlist autolink link image lists charmap print preview hr anchor pagebreak',
		      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		      'table emoticons template paste help'
		    ],
		    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
		      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
		      'forecolor backcolor emoticons | help',
		    menu: {
		      favs: {title: 'My Favorites', items: 'code visualaid | searchreplace'}
		    },
		    menubar: 'favs file edit view insert format tools table help'
		  });
		}

		$('#addTpl').click(function(){
			let rand = Math.floor(Math.random() * 10000);
			let html = `<div class="col-sm-12 py-5 tpl">
						    <form method="post" class="form-group">
								<input type="text" name="title" class="form-control" Placeholder="Email Templates">
							    <textarea id="mytextarea_${rand}" name="content" class="mt-3"></textarea>
							    <div class="row">
							    	<div class="col-11">
									    <input type="submit" class="btn btn-success mt-2 submitTpl" id="submit_${rand}" value="Save">
							    	</div>
							    	<div class="col-1 mt-2 text-center">
									    <button type="button" class="btn btn-danger btn-sm deleteTemplate"><i class="fa fa-trash"></i></button>
							    	</div>
							    </div>
						    </form>
						</div>`;
			$('#templatesContiainer').prepend(html);
			initializeTinymce(rand);
		});

		$(document).on('click', '.deleteTemplate', function(){
			$(this).parents('.tpl').remove();
		})

		$(document).on('click', '.submitTpl', function(e){
			e.preventDefault();
			let form = $(this).parents('form');
			tinymce.triggerSave();
			let content = form.find('[name="content"]').val();
			let title = form.find('[name="title"]').val();
			$.ajax({
				url: '<?=base_url().route_to('save.email.template')?>',
				type: 'POST',
				datType: 'json',
				data: {
					<?=csrf_token()?>: '<?=csrf_hash()?>',
					content: content,
					title: title,
				},
				success: function(res){
					console.log(res);
				}
			})
		})
	</script>