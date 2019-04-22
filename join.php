<?php

$recipient = "president@emptysky.org";
$required = array("name", "email", "action");

if (count($_POST) && !($missing = get_missing_fields()))
    send_mail();
else
    spit_form($missing);

function get_missing_fields() {
    global $required;
    $missing = array();
    foreach ($required as $field)
        if (!$_POST[$field])
            $missing[] = $field;
    return $missing;
}

function send_mail() {
    global $recipient;
    mail(
        $recipient,
        "Empty Sky Mailing List Request",
        "The following person wants to " . strtoupper($_POST['action']) . ":\n\n" .
            "    Name:  " . $_POST['name'] . "\n" .
            "    Email: " . $_POST['email'] . "\n" .
            "\nLove,\nYour Mother",
        "From: Your Mother <$recipient>");
    head();
    echo "<h2>Thanks</h2><p>Your request has been submitted.</p>";
    foot();
}

function spit_form($missing=array()) {
    head();
    echo "<h2>Join Our Mailing List</h2>";    
    if (count($missing))
        echo "<p><b style='color: #800'> Hey! You didn't give me your " .
            implode(" or ", $missing) . ". Try again.</b></p>";
    ?>
    <form id="join-form" action="<?=$_SERVER['PHP_SELF']?>" method="post">   
        <div>
            <label for="name">Full name:</label>
            <input type="text" name="name" id="name" value="<?=htmlentities($_POST['name'])?>">
        </div><div>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?=htmlentities($_POST['email'])?>">
        </div><div>
            <label for="action">I want to:</label>
            <select name="action" id="action">
                <option value="subscribe">subscribe</option>
                <option value="unsubscribe">unsubscribe</option>
            </select>
        </div>
        <input type="submit" value="Sign me up!">
    </form>
    <?php
    foot();
}

function head() {
    include(dirname(__FILE__) . "/new/header.phtml");
}

function foot() {
    include(dirname(__FILE__) . "/new/footer.phtml");
}

?>