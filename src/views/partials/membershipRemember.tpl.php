
<?php
    use App\Session;
    
?>
<div class="animated-div b-flex-center-center-col">
    <p class='message'>Your subscription will finish in <?php echo Session::getSession('days_to_finish') ?> days.</p>
    <a class="cssbuttons-io-button" href="/subscriptions">
    Renew
    <div class="icon">
        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
        </svg>
    </div>
</a>

</div>
<script>
    const div = document.querySelector('.animated-div');
         div.style.animation = 'slideIn 1s ease-in-out forwards';
        setInterval(() => {
        div.style.animation = 'slideOut 1s ease-in-out forwards';
    }, 6000) 
    
    
</script>