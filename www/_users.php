<<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php
	echo PRODUCTNAME;
	?> :: Пользователи</title>
    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">

    <link href="/jquery/jquery-ui.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/jquery/jquery-ui.theme.min.css" rel="stylesheet">
	<link href="/jquery/smarttab/styles/smart_tab_vertical.css" rel="stylesheet" type="text/css">	
	<link rel="stylesheet" href="/jasny-bootstrap/css/jasny-bootstrap.min.css">	

<style>
.rouble {
  position: relative; }

.rouble:before {
  display: block;
  content: "–";
  position: absolute;
  top: 0.15em; }
  
  .level_0{
  background-color: #A7FDBE !important;
  }
    .level_1{
  background-color: #FFB8BE !important;
  }
    .level_2{
  background-color: #F5F5A3 !important;
  }
</style>  


  <style>
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>

</head>
<body>
  
<?php
	global $userroles;
fixednavbar();

?>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h3>Редактирование услуг</h3>
      </div>
<button type="button" role="1" name="changeuser" id="changeuser0" title="Добавить пользователя">Добавить пользователя</button>
 <?php		

$bgs[0] = 'Нет';
$bgs[1] = 'Да';

 $tsql = "SELECT * FROM `users` WHERE `isactive` = 1 ORDER BY `id` ASC;";
	$r_serv = mysql_query($tsql);
	if (mysql_num_rows($r_serv)>0)
	{	
				echo '<table id = "uslugi" class = "tablesorter users"  style="width: 100%;">';
				echo 	'<colgroup>
						<col width="35%" />
						<col width="35%" />
						<col width="15%" />
						<col width="15%" />
						</colgroup>';

				echo  '<thead>
							<tr>
							<th class="sorter-false">Имя</th>
							<th class="sorter-false">Логин/Email</th>
							<th class="sorter-false">Роль/Права</th>
							<th class="sorter-false">Действие</th>
							</tr>
							</thead>';
	?>
<?php
			while ($row_serv = mysql_fetch_array($r_serv))
		{
				echo '<tr>';

							echo '
							<td><span id="username'.$row_serv["id"].'">'.$row_serv["realname"].'</span></td>
							<td><span id="userlogin'.$row_serv["id"].'">'.$row_serv["login"].'</span></td>
							<td><span id="userrole'.$row_serv["id"].'" >'.$userroles[$row_serv["role"]].'</span></td>
							<td><button type="button" role="'.$row_serv["role"].'" name="changeuser" id="changeuser'.$row_serv["id"].'" title="Изменить данные">Изменить</button></td>';
												
				echo '</tr>';
					
		}
				echo '</table>';
		
?>
<?php		
	}
?>		  

    </div>

<?php

//fixedbotbar();

?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/jquery/jquery.min.js"></script>
	<script src="/jquery/jquery.ui.datepicker-ru.js"></script>
	<script src="/jquery/jquery-ui.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/jquery/validator.js"></script>
	<script src="/jquery/jquery.cookie.js"></script>
	<script src="/jquery/smarttab/js/jquery.smartTab.min.js"></script>
	<script src="/jquery/jquery.json-2.4.js"></script>
	
		
	<!-- TableSorter core JavaScript ================================================== -->
		<!-- choose a theme file -->
<link rel="stylesheet" href="/css/theme.blue.css">

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.js"></script>
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="/jquery/jquery.tablesorter.widgets.js"></script>


	<script>

		$(document).ready(function(){
			// когда страница загружена

	
			$(".users")
			.tablesorter(
			{
				theme: 'blue',
				widgets: ['zebra']
			});


    var id, dialog, form, 
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name = $( "#name" ),
      login = $( "#login" ),
     pass1 = $( "#pass1" ),
      pass2 = $( "#pass2" ),
      role = $( "#role" ),
      allFields = $( [] ).add( name ).add( pass1 ).add( role ).add( pass2 ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Длина " + n + " должна быть между " +
          min + " и " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
     function checkpass( f, s ) {
      if ( f.val() != s.val() ) {
        f.addClass( "ui-state-error" );
        s.addClass( "ui-state-error" );
        updateTips( "Пароли не совпадают" );
        return false;
      } else {
        return true;
      }
    }
	
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      //valid = valid && checkRegexp( login, /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/, "Email заполнен неверно." );
      valid = valid && checkLength( login, "login/Email", 5, 100 );
      valid = valid && checkLength( name, "Имя пользователя", 3, 100 );
      valid = valid && checkLength( pass1, "Пароль", 5, 20 );
      valid = valid && checkLength( pass2, "Пароль", 5, 20 );
      valid = valid && checkpass( pass2, pass1 );
      valid = valid && checkLength( role, "Роль/Права", 1, 1 );
 
     //valid = valid && checkRegexp( description, /^[a-z]([0-9a-z_\s])+$/i, "Недопустимые символы." );
       //valid = valid && checkRegexp( price, /^([0-9.])+$/, "Цена должна состоять только из цифр : 0-9" );
 
      if ( valid ) 
	  {

		$.ajax({
			type: "POST",
			url: "functions.php",
			data: { operation: 'adduser', username: name.val(), userpass: pass1.val(), userrole: role.val(), userid: id, userlogin: login.val()}
		})
		.done(function( msg ) {
			if(msg == 'yes'){
				alert ('Изменения в список услуг внесены.');
				location.href="?users";
				} else {
				alert ('Что-то пошло не так. '+msg);
				}
		});
		
		
		
	}
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 350,
      width: 400,
      modal: true,
      buttons: {
        "Сохранить": addUser,
        "Отмена": function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
  form[ 0 ].reset();
    $( document ).on( "click", "button[name=changeuser]", function() {
					id = $(this).attr("id");
				id = id.substr(10);

				$('#realname').val($('#username'+id).html());
				$('#login').val($('#userlogin'+id).html());
				$('#role').val($(this).attr("role"));
				
      dialog.dialog( "open" );
    });
  });
	</script>
 <div id="dialog-form" title="Заполните информацию по пользователю">
  <p class="validateTips">Все поля должны быть заполнены.</p>
  <form>
	<input type="text" id="login" placeholder="Email" class="form-control" value="">
	<input type="text" id="realname" placeholder="Имя пользователя" class="form-control" value="">
	<input type="text" id="pass1" placeholder="Пароль" class="form-control" value="">
	<input type="text" id="pass2" placeholder="Повторите пароль" class="form-control" value="">
	<select  id="role" class="form-control">
	<?php
	foreach($userroles as $num => $val) {
	
	echo '<option value="'.$num.'">'.$val.'</option>';
	}
	
	?>

	</select>
 </form>
</div>
 </body>
</html>
