<div flex="v" h-center contain="info" nopadding style="width: 250px; padding: 1em 0; height: 100vh; background-color: #0f2755; flex-shrink: 0;" sharp-edges>
    <div fullwidth flex="v" style="padding: 0 1.5em;" nogap>
        <h1 nomargin white-text text="big">ISA</h1>
        <span white-text>Client Panel</span>
    </div>
    <div flex="v" nogap noshadowtoall fullwidth>
        <a href="../client/account-details" button contain="overdark" flex="h" h-center v-center style="border-radius: 0; width: 100%;" nogap>
            <span style="flex-shrink: 0;" flex="h" v-center><img src="../views/assets/img/account_circle.svg" alt="">Account Details</span>
            <div flex="h" h-end style="width: 100%;">
                <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="right arrow">
            </div>
        </a>
        <a href="../client/notifications?user_id=<?php echo $_SESSION["id"]; ?>&param=unread" button contain="overdark" flex="h" h-center v-center style="border-radius: 0; width: 100%;" nogap>
            <span style="flex-shrink: 0;" flex="h" v-center><img src="../views/assets/img/notification_white.svg" alt="">
                Notifications
                <span id="notif-count" style="padding: .5em; background: rgb(0 0 0 / .4); border-radius: .3em;">
                    <?php echo count((new \Main\Models\FetchModel)->notificationsUnread(["user_id" => $_SESSION["id"]])["rows"]); ?>
                </span>
            </span>
            <div flex="h" h-end style="width: 100%;">
                <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="right arrow">
            </div>
        </a>
        <a href="../client/cart" button contain="overdark" flex="h" h-center v-center style="border-radius: 0; width: 100%;" nogap>
            <span style="flex-shrink: 0;" flex="h" v-center><img src="../views/assets/img/cart.svg" alt="">Shopping Cart</span>
            <div flex="h" h-end style="width: 100%;">
                <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="right arrow">
            </div>
        </a>
        <a href="../client/order-history" button contain="overdark" flex="h" h-center v-center style="border-radius: 0; width: 100%;" nogap>
            <span style="flex-shrink: 0;" flex="h" v-center><img src="../views/assets/img/history.svg" alt="">Order History</span>
            <div flex="h" h-end style="width: 100%;">
                <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="right arrow">
            </div>
        </a>
        <a href="../home/index" button contain="overdark" flex="h" h-center v-center style="border-radius: 0; width: 100%;" nogap>
            <span style="flex-shrink: 0;" flex="h" v-center><img src="../views/assets/img/shopping.svg" alt="">Store</span>
            <div flex="h" h-end style="width: 100%;">
                <img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="right arrow">
            </div>
        </a>
        <a href="../auth/logout" button contain="overdark" flex="h" h-center v-center style="border-radius: 0; width: 100%;" nogap>
            <span style="flex-shrink: 0;" flex="h" v-center><img src="../views/assets/img/power.svg" alt="">Logout</span>
            <div flex="h" h-end style="width: 100%;"><img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="right arrow"></div>
        </a>
    </div>
</div>