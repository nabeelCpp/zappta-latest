<?php if (!isset($show_newsletter)) {  ?>
    <section class="joinFree">
        <div class="container">

            <div class="innerJoinFree">
                <div class="d-flex flex-column">
                    <h4>JOIN FREE NOW & WIN BIG!</h4>
                    <p>Instant! Get 300 Bonus Coins—enough for 300 extra spins!</p>
                </div>
                <div class="newsletter">
                    <div class="input-group">
                        <div class="form-outline">
                            <input type="email" required name="footer-news" id="footernews" placeholder="Email address" class="form-control" />
                        </div>
                        <button type="button" class="btn btn-primary" id="join_now_newsletter">
                            <i class="fas fa-angle-right"></i>
                        </button>
                    </div>
                    <div class="alert alert-success text-center d-none mt-3" id="newsletter_alert">
                        Newsletter Subscribed successfully!
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<script>
    $('#join_now_newsletter').click(function() {
        let input = $('#footernews').val();
        $(this).attr('disabled', true);
        if (!input) {
            return false;
        }
        setTimeout(() => {
            $('#newsletter_alert').removeClass('d-none');
        }, 3000);
        setTimeout(() => {
            $('#newsletter_alert').addClass('d-none');
        }, 6000);
    });
</script>