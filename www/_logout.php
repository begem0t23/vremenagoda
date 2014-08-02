<?php
	unset($_COOKIE["scuruser"]);
	unset($_SESSION["curusersession"]);
	unset($_SESSION["curuser"]);
	unset($_SESSION["curusername"]);
    setcookie('scuruser', null, -1);
	Header("Location: /");
?>