<div class='right-sidebar'>

    <a class='<?php if (str_contains($_SERVER['PHP_SELF'], "profile.php")) {
        echo "active-side-tab ";
    }
    ; ?>right-nav-item'
        id='my-profile' href='./profile.php'>
        <img class='right-nav-item-img' src='<?php echo "./" . $_SESSION['user']['profile_picture']; ?>'>
        <span>My Profile</span>
    </a>
    <hr>
    <a class='<?php if (str_contains($_SERVER['PHP_SELF'], "setting.php")) {
        echo "active-side-tab ";
    }
    ; ?>right-nav-item' href='./setting.php'>
        <img class='right-nav-item-img' src='./assets/images/settings.png'>
        <span>Setting</span>
    </a>
    <a class='<?php if (str_contains($_SERVER['PHP_SELF'], "logout.php")) {
        echo "active-side-tab ";
    }
    ; ?>right-nav-item' href='./logout.php'>
        <img class='right-nav-item-img' src='./assets/images/logout.png'>
        <span>Logout</span>
    </a>
</div>
</div>