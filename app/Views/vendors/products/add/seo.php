<div class="row">
	<div class="col-xl-10 col-lg-10 col-md-10 col-12">
		<div class="form-row">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Search Engine Optimization</label>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label>
						<span class="tit">Meta title</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="right" title="Public title for the product page and for search engines. Leave blank to use the product name. The number of remaining characters is displayed to the left of the field.">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<div class="position-relative">
						<input type="text" name="product[seo][metatitle]" class="form-control" data-required="Meta title is required!" required placeholder="To have a different title from the product name, enter it here." value="<?php print isset($getData['product']['seo']['metatitle']) ? $getData['product']['seo']['metatitle'] : '';?>">
					</div>
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-3">
					<label>
						<span class="tit">Meta description</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="right" title="This description will appear in search engines. You need a single sentence, shorter than 200 characters (including spaces)">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<div class="position-relative">
						<textarea name="product[seo][description]" class="form-control" placeholder="To have a different title from the product name, enter it here." maxlength="200"><?php print isset($getData['product']['seo']['description']) ? $getData['product']['seo']['description'] : '';?></textarea>
					</div>
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-3">
					<label>
						<span class="tit">Meta Keywords</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="right" title="Define keywords for search engines">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<div class="position-relative">
						<textarea name="product[seo][keywords]" class="form-control" placeholder="Meta keywords are meta tags that you can use to give search engines more information about a product content"><?php print isset($getData['product']['seo']['keywords']) ? $getData['product']['seo']['keywords'] : '';?></textarea>
						<small>for example ( keyword, product )</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>