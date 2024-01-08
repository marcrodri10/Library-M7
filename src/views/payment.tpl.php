<?php
include_once 'partials/header.tpl.php';
if(isset($subscription)){
    if($subscription == 'trial') $amount = 0;
    else $amount = 1;
}

?>
<!-- Modal -->
<form action="/subscriptions/subscribe" method="post">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment</h1>
                <a href="/subscriptions" class="btn-close" aria-label="Close" value="cancel"></a>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name='name' value="<?php if($userCard !== []) echo $userCard->getName() ?>" required>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">Card:</label>
                <input type="text" class="form-control" id="card" name='card' value="<?php if($userCard !== []) echo $userCard->getCard() ?>" required>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">CVV:</label>
                <input type="text" class="form-control" id="cvv" name='cvv' value="<?php if($userCard !== []) echo $userCard->getCvv() ?>" required>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">Amount:</label>
                <input type="text" class="form-control" id="amount" name='amount' readonly value="<?php echo $amount ?> €">
            </div>
            <div class="modal-footer">
                <a href="/subscriptions" class="btn btn-danger" name="payment">Close</a>
                <button type="submit" class="btn btn-primary"  name="payment" value="pay-<?php echo $subscription."-";echo $amount?>">Pay</button>
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