<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
	if (!isset($path_to_root) || isset($_GET['path_to_root']) || isset($_POST['path_to_root']))
		die(_("Restricted access"));
	include_once($path_to_root . "/includes/ui.inc");
	include_once($path_to_root . "/includes/page/header.inc");

	$js = "<script language='JavaScript' type='text/javascript'>
function defaultCompany()
{
	document.forms[0].company_login_name.options[".user_company()."].selected = true;
}
</script>";

	add_js_file('login.js');
	// Display demo user name and password within login form if allow_demo_mode option is true
	if ($SysPrefs->allow_demo_mode == true)
	{
	    $demo_text = _("Login as user: demouser and password: password");
	}
	else
	{
		$demo_text = _("Please login here");
    	if (@$SysPrefs->allow_password_reset) {
      		$demo_text .= " "._("or")." <a href='$path_to_root/index.php?reset=1'>"._("request new password")."</a>";
    	}
	}

	if (check_faillog())
	{
		$blocked = true;

	    $js .= "<script>setTimeout(function() {
	    	document.getElementsByName('SubmitUser')[0].disabled=0;
	    	document.getElementById('log_msg').innerHTML='$demo_text'}, 1000*".$SysPrefs->login_delay.");</script>";
	    $demo_text = '<span class="redfg">'._('Too many failed login attempts.<br>Please wait a while or try later.').'</span>';
	} elseif ($_SESSION["wa_current_user"]->login_attempt > 1) {
		$demo_text = '<span class="redfg">'._("Invalid password or username. Please, try again.").'</span>';
	}

	flush_dir(user_js_cache());
	if (!isset($def_coy))
		$def_coy = 0;
	$def_theme = "default";

	$login_timeout = $_SESSION["wa_current_user"]->last_act;

	$title = $login_timeout ? _('Authorization timeout') : $SysPrefs->app_title." ".$version." - "._("Login");
	$encoding = isset($_SESSION['language']->encoding) ? $_SESSION['language']->encoding : "iso-8859-1";
	$rtl = isset($_SESSION['language']->dir) ? $_SESSION['language']->dir : "ltr";
	$onload = !$login_timeout ? "onload='defaultCompany()'" : "";

	echo "<!DOCTYPE html>\n";
	echo "<html class='loading' lang='en' data-textdirection='ltr'>\n";
	echo "<head>\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>\n";
	echo "<meta name='author' content='PIXINVENT'>\n";
	echo "<title>PT. Surgana Rasa Lestari - Login Page\n";
	echo "</title>\n";
	echo "<link rel='apple-touch-icon' href='$path_to_root/themes/$def_theme/app-assets/images/ico/apple-icon-120.png'>\n";
	echo "<link rel='shortcut icon' type='image/x-icon' href='$path_to_root/themes/$def_theme/app-assets/images/ico/favicon.ico'>\n";
	echo "<link href='https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600' rel='stylesheet'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/vendors/css/vendors.min.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/bootstrap.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/bootstrap-extended.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/colors.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/components.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/themes/dark-layout.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/themes/semi-dark-layout.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/core/menu/menu-types/vertical-menu.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/core/colors/palette-gradient.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/app-assets/css/pages/authentication.css'>\n";
	echo "<link rel='stylesheet' type='text/css' href='$path_to_root/themes/$def_theme/assets/css/style.css'>\n";
	echo "</head>\n";

	echo "<body class='vertical-layout vertical-menu-modern semi-dark-layout 1-column navbar-floating footer-static bg-full-screen-image blank-page blank-page' data-open='click' data-menu='vertical-menu-modern' data-col='1-column' data-layout='semi-dark-layout'>\n";
	echo "<div class='app-content content'>\n";
	echo "<div class='content-overlay'>\n";
	echo "</div>\n";
	echo "<div class='header-navbar-shadow'>\n";
	echo "</div>\n";
	echo "<div class='content-wrapper'>\n";
	echo "<div class='content-header row'>\n";
	echo "</div>\n";
	echo "<div class='content-body'>\n";
	echo "<section class='row flexbox-container'>\n";
	echo "<div class='col-xl-8 col-11 d-flex justify-content-center'>\n";
	echo "<div class='card bg-authentication rounded-0 mb-0'>\n";
	echo "<div class='row m-0'>\n";
	echo "<div class='col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0'>\n";
	echo "<img src='$path_to_root/themes/$def_theme/app-assets/images/pages/login.png' alt='branding logo'>\n";
	echo "</div>\n";
	echo "<div class='col-lg-6 col-12 p-0'>\n";
	echo "<div class='card rounded-0 mb-0 px-2'>\n";
	echo "<div class='card-header pb-1'>\n";
	echo "<div class='card-title'>\n";
	echo "<h4 class='mb-0'>Login\n";
	echo "</h4>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "<p class='px-2'>\n";

	label_cell($demo_text, "colspan=2 align='center' id='log_msg'");
	
	echo "</p>\n";

	start_form(false, false, $_SESSION['timeout']['uri'], "loginform");

	echo "<div class='card-content'>\n";
	echo "<div class='card-body pt-1'>\n";
	
	echo "<fieldset class='form-label-group position-relative has-icon-left'>\n";
	echo "<input type='text' class='form-control' name='user_name_entry_field' placeholder='Username'>\n";
	echo "<div class='form-control-position'>\n";
	echo "<i class='feather icon-user'>\n";
	echo "</i>\n";
	echo "</div>\n";
	echo "<label for='user-password'>Username\n";
	echo "</label>\n";
	echo "</fieldset>\n";

	echo "<fieldset class='form-label-group position-relative has-icon-left'>\n";
	echo "<input type='password' class='form-control' name='password' placeholder='Password'>\n";
	echo "<div class='form-control-position'>\n";
	echo "<i class='feather icon-lock'>\n";
	echo "</i>\n";
	echo "</div>\n";
	echo "<label for='user-password'>Password\n";
	echo "</label>\n";
	echo "</fieldset>\n";

	echo "<div class='form-group d-flex justify-content-between align-items-center'>\n";
	echo "<div class='text-left'>\n";

	if ($login_timeout) {
		hidden('company_login_name', user_company());
	} else {
		$coy =  user_company();
		if (!isset($coy))
			$coy = $def_coy;
		if (!@$SysPrefs->text_company_selection) {
			echo "<select class='form-control' name='company_login_name'>\n";
			for ($i = 0; $i < count($db_connections); $i++)
				echo "<option value=$i ".($i==$coy ? 'selected':'') .">" . $db_connections[$i]["name"] . "</option>";
			echo "</select>\n";
		} else {
			text_row(_(""), "company_login_nickname", "", 50, 50);
		}
	};

	echo "</div>\n";
	echo "</div>\n";
	echo "<button type='submit' class='btn btn-primary float-right btn-inline'>Login\n";
	echo "</button>\n";
	end_form(1);
	echo "</div>\n";
	echo "</div>\n";
	echo "<div class='login-footer'>\n";
	echo "<div class='divider'>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</section>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	echo "<script src='$path_to_root/themes/$def_theme/app-assets/vendors/js/vendors.min.js'>\n";
	echo "</script>\n";
	echo "<script src='$path_to_root/themes/$def_theme/app-assets/js/core/app-menu.js'>\n";
	echo "</script>\n";
	echo "<script src='$path_to_root/themes/$def_theme/app-assets/js/core/app.js'>\n";
	echo "</script>\n";
	echo "<script src='$path_to_root/themes/$def_theme/app-assets/js/scripts/components.js'>\n";
	echo "</script>\n";
	echo "</body>\n";
	echo "</html>\n";
	$Ajax->addScript(true, "if (document.forms.length) document.forms[0].password.focus();");

    echo "<script language='JavaScript' type='text/javascript'>
    //<![CDATA[
            <!--
            document.forms[0].user_name_entry_field.select();
            document.forms[0].user_name_entry_field.focus();
            //-->
    //]]>
    </script>";
    div_end();

