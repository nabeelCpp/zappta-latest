<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h2 style="font-family: Alumni Sans !important; font-size: 3.125rem;"><b>Return Policy</b></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-3 mt-5">
            <div>
                <h1 style="font-family: Alumni Sans !important; font-size: 2.125rem;">Contact Us</h1>
                <img class="img-responsive  mt-4" style="width: 60px; margin-left: 24px;" alt="" src="https://zappta.com/theme/image/cell.png" />
                <p class="mt-4">+92 64537534785</p>
                <p class="mt-4">+92 78458963789</p>
                <img class="img-responsive mt-4" style="width: 60px; margin-left: 30px;" alt="" src="https://zappta.com/theme/image/doublemail.png" /><br />
                <p class="mt-4" style="margin-left: 10px;">Get Support</p>
                <img class="img-responsive mt-5" style="width: 49px; margin-left: 36px;" alt="" src="https://zappta.com/theme/image/email.png" />
                <p class="mt-4">zappta@gmail.com</p>
            </div>
        </div>
        <div class="col-9">
            <h5 class="mt-4" style="font-family: Alumni Sans !important; font-size: 2.125rem;"><b>Product Return Policy</b></h5>
            <br />
            <p>We have an easy return policy with the ultimate goal of making our customers happy. We stand behind our goods and services and want customers to be satisfied with them.</p>
            <br />
            <p>If your Zappta product does not meet your satisfaction or product breaks during shipment or has any defect, you may return it within 30 days of purchase, except for customized items fresh and grocery Items. To return an item (excluding sample products), the item must be new, unused, and in its original packaging. You may return the item to Zappta by mail. If you want to return an item by mail, follow the steps below:</p>
            <br />
            <ul>
                <li>
                    <p>Call/Email our Customer Care.</p>
                </li>
                <li>
                    <p>Our agent will prepare and provide a return shipping label via email.</p>
                </li>
                <li>
                    <p>Print the return label and adhere it to your package.</p>
                </li>
                <li>
                    <p>Drop off the package at your nearest UPS location.</p>
                </li>
            </ul>
            <h4 style="font-family: Alumni Sans !important; font-size: 2.125rem;">Return Product can be compensated through 2 methods</h4>
            <br />
            <p style="font-family: Alumni Sans !important; font-size: 2.125rem;">1: Refunds</p>

            <p>The appropriate tax amount by item will be included with your refund. Original shipping and handling fees (if applicable) may be deducted from the value of your refund unless the return is a result of our error. Refunds will be issued in the form of purchase gift cards.</p>

            <p style="font-family: Alumni Sans !important; font-size: 2.125rem;">2: Exchanges</p>
            <p>The product can be exchanged in 2 ways.</p>
            <ul>
                <li>Customers can exchange a product for some other product (the price should be the same).</li>
                <li>Customers can exchange products with the same product. If the previous product has some breakage or defect.</li>
            </ul>
            <br />
            <h4 style="font-family: Alumni Sans !important; font-size: 2.125rem;">Exceptions to General Return Policy</h4>
            <br />
            <ul>
                <li>
                    <p>Products are returnable or exchangeable only if the packaging is unopened and a receipt is provided. Items damaged or deemed defective during the manufacturer&rsquo;s warranty period must be returned directly to the manufacturer, except returns as required by law.</p>
                </li>
                <li>Shipping costs will be the responsibility of the customer in cases of buyer&rsquo;s remorse returns, such as an item didn&rsquo;t fit, didn&rsquo;t like the color/quality, changed your mind, ordered by mistake, bought it somewhere else, etc.</li>
                <li>We will refund the cost of the merchandise and shipping charges if the return is a result of our error or defective product.</li>
                <li>Gift cards and Prepaid Cards are not returnable or exchangeable, except where required by law.</li>
                <li>Returns are processed in 10-14 business days and refunds can be expected 5-7 business days after processing.</li>
                <li>Zappta reserves the right to limit returns or exchanges.</li>
                <li>Restocking fees may be applied.</li>
            </ul>
            <div class="mt-4 mb-5">
                <div class="row">
                    <div class="col-6">
                        <p>Was this page Helpful?</p>
                    </div>
                    <div class="col-6">
                        <form action="<?php print base_url() . '/page-feedback'; ?>" method="POST"><input id="pages_feedback" type="hidden" value="&lt;?php print csrf_hash() ?&gt;" /> <button id="yes" class="btn " style="border: 1px solid black;" name="submit" value="yes" type="submit"> Yes </button> <button id="no" class="btn " style="border: 1px solid black;" name="submit" value="no" type="submit"> No </button>
                            <input type="hidden" name="hiddenpage" value="returnpolicy">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>