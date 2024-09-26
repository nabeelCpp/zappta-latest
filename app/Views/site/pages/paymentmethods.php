<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
	<div class="py-5">

		<?= htmlspecialchars_decode($page['content']); ?>
	</div>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>