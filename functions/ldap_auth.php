<?php
session_start();

$adServer = "ldap://e4008s01sv001.indigo.schools.internal";
$ldap = ldap_connect($adServer);

if(isset($_POST['username']) && isset($_POST['password']) && $_POST['password'] != ''){


    $username = $_POST['username'];
    $password = $_POST['password'];
    echo $password == '';

    $ldaprdn = 'INDIGO' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);
    if ($bind) {
	$_SESSION['username'] = $_POST['username'];
    }

}

header('Location: http://localhost/bookit');
@ldap_close($ldap);


?>
