<?php
include_once 'partials/header.tpl.php';
use App\Session;
use App\Model\Card;

if(isset($subscription)){
    if($subscription == 'trial') $amount = 0;
    else $amount = 1;
}


?>
<!-- Modal -->
<form action="/card/addCard" method="post">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment</h1>
                <a href="/subscriptions" class="btn-close" aria-label="Close" value="cancel"></a>
            </div>
            <div class="modal-body">
                <input type='text' class='form-control input payment-input' id='name' name='name' value="" placeholder="Name" required>
            </div>
            <div class="modal-body">
                <input type='text' class='form-control input payment-input' id='card' name='card' value="" placeholder="Card Number" required>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control input payment-input" id="cvv" name='cvv' value="" placeholder="CVV" required>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control input payment-input" id="amount" name='amount' readonly value="<?php echo $amount ?> €">
            </div>
            <div class="modal-footer">
                <a class="cssbuttons-io-button button-cancel" href="/subscriptions">
                    Cancel
                    <div class="icon">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </a>
                <?php
                    if($type == 'add'){
                        echo '<button class="cssbuttons-io-button" type="submit" name="payment" value="pay-'.$subscription."-" . $amount.'">
                        Add
                        <div class="icon">
                            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                            </svg>
                        </div>
                    </button>';
                    }
                    
                ?>  
            </div>
            </div>
        </div>
    </div>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = new bootstrap.Modal(document.getElementById("staticBackdrop"));
        modal.show();
    });
</script>