<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url('assets/images/logo.png') ?>" width="30" height="30" class="d-inline-block align-top" alt="">
            <strong>SIMS PPOB</strong>
        </a>

        <div class="float-right">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-dark" id="topup-tab" href="<?= base_url('topup') ?>"><strong>Top Up</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" id="transaction-tab" href="<?= base_url('transaction') ?>"><strong>Transaction</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" id="account-tab" href="<?= base_url('account') ?>"><strong>Account</strong></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>