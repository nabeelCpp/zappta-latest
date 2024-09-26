<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?= htmlspecialchars_decode($page['content']); ?>
<div class="row p-5">
	<div class="col-md-3" style="margin-left: 450px;">
		<p class="h5">Help Us Improve</p>
		<span class="text-muted">Was this page helpful?</span>
	</div>

	<div class="col-md-3">
		<form action="<?php print base_url() . '/page-feedback'; ?>" method="POST"><button class="btn btn-warning btn-md btn-rounded p-2" style="background: #FB5000; color: white; border-radius: 12px;" name="submit" type="submit" value="yes"> Yes</button> <button class="btn btn-light btn-md btn-rounded p-2" style="border: 0.5px solid #FB5000; color: #fb5000; border-radius: 12px;" name="submit" type="submit" value="no"> No</button>
			<input name="hiddenpage" type="hidden" value="helppage" />
		</form>
	</div>
</div>

<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>