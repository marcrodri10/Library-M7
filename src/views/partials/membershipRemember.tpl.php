
<?php
    use App\Session;
    
    $finish = new DateTime(Session::getSession('user_subscription')->getFinishDate());

    $now = new DateTime();
    
    $days = $finish->diff($now);
    
    $days = ($days->y)*365 + $days->d;
    

?>
<div class="animated-div">
    <?php if($days <= 10){
    echo "<p>Your subscription will finish in $days days.</p>";
    } ?>
</div>
<script>
    const div = document.querySelector('.animated-div');
    
    if(div.childElementCount > 0){
        div.style.display = 'block';
        div.style.animation = 'slideIn 1s ease-in-out forwards';
        setInterval(() => {
        div.style.animation = 'slideOut 1s ease-in-out forwards';
    }, 6000)
    }
    
</script>