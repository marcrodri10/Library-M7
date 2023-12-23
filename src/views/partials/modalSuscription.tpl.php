
<?php
    use App\Session;

?>
<!-- Modal -->
<form action="/suscriptions" method="post">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">We have seen you are not suscribed</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Maybe you would like to suscribe to read all the catalog.
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><?php if(Session::getSession('user_suscription') !== false){
                    echo 'Suscription plans';
                }
                else echo '1 month trial' ?></button>
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