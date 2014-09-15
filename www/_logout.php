<?php
	unset($_COOKIE["scuruser"]);
	unset($_SESSION["curusersession"]);
	unset($_SESSION["curuser"]);
	unset($_SESSION["curusername"]);
    setcookie('scuruser', null, -1);
	Header("Location: /?" . rand());
	
	setCookie("clientname", null, -1);
	setCookie("clientid", null, -1);
	setCookie("clientphone", null, -1);
	setCookie("clientfrom", null, -1);
	setCookie("clientfrom4", null, -1);
	setCookie("clientemail", null, -1);
	setCookie("dateevent", null, -1);
	setCookie("timeevent", null, -1);
	setCookie("guestcount", null, -1);
	setCookie("hall", null, -1);
	setCookie("dishes", null, -1);
	setCookie("service", null, -1);
	setCookie("tables", null, -1);
	setCookie("editclientid", null, -1);

?>