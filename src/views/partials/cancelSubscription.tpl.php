<?php
use App\Session;

?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Your subscription</h5>
        <ul class="list-group check-list">
            <li class="list-group-item">
                <strong>Start Date:</strong> <?php echo Session::getSession('user_subscription')->getStartDate()?>
            </li>
            <li class="list-group-item">
                <strong>Finish Date:</strong><?php echo Session::getSession('user_subscription')->getFinishDate()?>
            </li>
            <li class="list-group-item">
                <strong>Subscription Type:</strong><?php echo ucfirst(Session::getSession('user_subscription')->getType())?>
            </li>
            <li class="b-flex-center-center-row">
                <button class="cssbuttons-io-button button-cancel w-100" type="submit" name="subscription" value="cancel">
                    Cancel
                    <div class="icon">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
            </li>
        </ul>
    </div>
</div>