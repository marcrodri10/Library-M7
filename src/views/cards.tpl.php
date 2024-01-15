<?php 
include_once 'partials/header.tpl.php';

use App\Model\Card; 
?>
<body>
<?php include_once 'partials/nav.tpl.php'; ?>
    <div class="b-flex-center-center-col cards-table">
        <form action="/subscriptions/formHandler" method="post" class="w-100 b-flex-center-center-col">
            <?php if (isset($subscription)) : ?>
                <?php $amount = ($subscription == 'trial') ? 0 : 1; ?>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">My Cards</th>
                        <th scope="col">Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $first = true; ?>
                    <?php foreach ($cards as $card) : ?>
                        <?php $userCardClass = new Card($card->card_id, $card->name, $card->card, $card->cvv); ?>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user-card" id="card-<?php echo $userCardClass->getCardId(); ?>" value="pay-<?php echo $subscription . '-' . $amount . '-' . $userCardClass->getCardId(); ?>" <?php echo ($first) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="card-<?php echo $userCardClass->getCardId(); ?>">
                                        <?php echo $userCardClass->getCard(); ?>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <label for="card-<?php echo $userCardClass->getCardId(); ?>">
                                    <?php echo $userCardClass->getName(); ?>
                                </label>
                            </td>
                        </tr>
                        <?php $first = false; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="options b-flex-center-center-row">
                <button class="cssbuttons-io-button cards-btn" type="submit">
                    PAY
                    <div class="icon b-flex-center-center ">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </button>
                <a class="cssbuttons-io-button cards-btn" type="submit" href="/card/add">
                    ADD
                    <div class="icon b-flex-center-center">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" fill="currentColor"></path>
                        </svg>
                    </div>
                </a>
            </div>

        </form>


    </div>
</body>

</html>