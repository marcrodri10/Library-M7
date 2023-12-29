<?php
include_once 'partials/header.tpl.php';
if(isset($_COOKIE['suscription'])){
    if($_COOKIE['suscription'] == 'trial') $amount = 0;
    else $amount = 12;
}

?>
<!-- Modal -->
<form action="/suscriptions/payment" method="post">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name='name'>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">Card:</label>
                <input type="text" class="form-control" id="card" name='card'>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">CVV:</label>
                <input type="text" class="form-control" id="cvv" name='cvv'>
            </div>
            <div class="modal-body">
                <label for="text" class="form-label">Amount:</label>
                <input type="text" class="form-control" id="card" name='card' readonly value="<?php echo $amount ?> €">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" name="payment" value="cancel">Close</button>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="payment" value="pay-<?php echo $_COOKIE['suscription']."-";echo $amount?>">Pay</button>
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