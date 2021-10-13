<?php

	class renderer
	{
		function wa_get_apps($title, $applications, $sel_app)
		{
			foreach($applications as $app)
			{
				foreach ($app->modules as $module)
				{
					$apps = array();
					foreach ($module->lappfunctions as $appfunction)
						$apps[] = $appfunction;
					foreach ($module->rappfunctions as $appfunction)
						$apps[] = $appfunction;
					$application = array();	
					foreach ($apps as $application)	
					{
						$url = explode('?', $application->link);
						$app_lnk = $url[0];					
						$pos = strrpos($app_lnk, "/");
						if ($pos > 0)
						{
							$app_lnk = substr($app_lnk, $pos + 1);
							$lnk = $_SERVER['REQUEST_URI'];
							$url = explode('?', $lnk);
							$asset = false;
							if (isset($url[1]))
								$asset = strstr($url[1], "FixedAsset");
							$lnk = $url[0];					
							$pos = strrpos($lnk, "/");
							$lnk = substr($lnk, $pos + 1);
							if ($app_lnk == $lnk)  
							{
								$acc = access_string($app->name);
								$app_id = ($asset != false ? "assets" : $app->id);
								return array($acc[0], $module->name, $application->label, $app_id);
							}	
						}	
					}
				}
			}
			return array("", "", "", $sel_app);
		}
		
		function wa_header()
		{
			page(_($help_context = "Main Menu"), false, true);
		}

		function wa_footer()
		{
			end_page(false, true);
		}
		function shortcut($url, $label) 
		{
			echo "<li>";
			echo menu_link($url, $label);
			echo "</li>";
		}
		function menu_header($title, $no_menu, $is_index)
		{
			global $path_to_root, $SysPrefs, $version;

			$sel_app = $_SESSION['sel_app'];
			echo "<div class='fa-main'>\n";
			if (!$no_menu)
			{
				$applications = $_SESSION['App']->applications;
				$local_path_to_root = $path_to_root;
				$pimg = "<img src='$local_path_to_root/themes/".user_theme()."/images/preferences.gif' style='width:14px;height:14px;border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Preferences')."'>&nbsp;&nbsp;";
				$limg = "<img src='$local_path_to_root/themes/".user_theme()."/images/lock.gif' style='width:14px;height:14px;border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Change Password')."'>&nbsp;&nbsp;";
				$img = "<img src='$local_path_to_root/themes/".user_theme()."/images/on_off.png' style='width:14px;height:14px;border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Logout')."'>&nbsp;&nbsp;";
				$himg = "<img src='$local_path_to_root/themes/".user_theme()."/images/help.gif' style='width:14px;height:14px;border:0;vertical-align:middle;padding-bottom:3px;' alt='"._('Help')."'>&nbsp;&nbsp;";
				echo "<nav class='header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-shadow navbar-brand-center'>\n";
				echo "<div class='navbar-header d-xl-block d-none'>\n";
				echo "<ul class='nav navbar-nav flex-row'>\n";
				echo "<li class='nav-item'><a class='navbar-brand' href='#'>\n";
				echo "<div class='brand-logo'></div>\n";
				echo "</a></li>\n";
				echo "</ul>\n";
				echo "</div>\n";

				echo "<div class='navbar-wrapper'>\n";
				echo "<div class='navbar-container content'>\n";
				echo "<div class='navbar-collapse' id='navbar-mobile'>\n";
				echo "<div class='mr-auto float-left bookmark-wrapper d-flex align-items-center'>\n";
				echo "<ul class='nav navbar-nav'>\n";
				echo "<li class='nav-item mobile-menu d-xl-none mr-auto'><a class='nav-link nav-menu-main menu-toggle hidden-xs' href='#'><i class='ficon feather icon-menu'></i></a></li>\n";
				echo "</ul>\n";

				echo "<ul class='nav navbar-nav bookmark-icons'>\n";
				echo "<li class='nav-item d-none d-lg-block'><a class='nav-link' href='$path_to_root/admin/dashboard.php?sel_app=$sel_app' data-toggle='tooltip' data-placement='top' title='Dashboard'><i class='ficon feather icon-home'></i></a></li>\n";

				echo "<li class='nav-item d-none d-lg-block'><a class='nav-link' href='app-chat.html' data-toggle='tooltip' data-placement='top' title='Chat'><i class='ficon feather icon-message-square'></i></a></li>\n";

				echo "<li class='nav-item d-none d-lg-block'><a class='nav-link' href='app-email.html' data-toggle='tooltip' data-placement='top' title='Email'><i class='ficon feather icon-mail'></i></a></li>\n";

				// echo "<li class='nav-item d-none d-lg-block'><a class='nav-link' href='app-calender.html' data-toggle='tooltip' data-placement='top' title='Calendar'><i class='ficon feather icon-calendar'></i></a></li>\n";
				echo "</ul>\n";

				echo "</div>\n";
				echo "<ul class='nav navbar-nav float-right'>\n";
				echo "<li class='dropdown dropdown-user nav-item'><a class='dropdown-toggle nav-link dropdown-user-link' href='#' data-toggle='dropdown'>\n";

				echo "<div class='user-nav d-sm-flex d-none'>
					<span class='user-name text-bold-600'>" . $_SESSION["wa_current_user"]->name . "</span>
					<span class='user-status text-bold-600' style='color:green'>".Today() . "&nbsp;" . Now()."</span>
					</div>
					<span>
					<img class='round' src='$path_to_root/themes/default/images/users.png' alt='avatar' height='40' width='40'></span>\n";
				echo "</a>\n";

				echo "<div class='dropdown-menu dropdown-menu-right'>
				<a class='dropdown-item' href='$path_to_root/admin/change_current_user_password.php?selected_id=" . $_SESSION["wa_current_user"]->username . "'><i class='feather icon-user'></i> " . _("Change password") . "</a>

				<a class='dropdown-item' href='$path_to_root/admin/display_prefs.php?'><i class='feather icon-settings'></i> " . _("Preferences") . "</a>\n";

				echo "<div class='dropdown-divider'></div><a class='dropdown-item' href='$local_path_to_root/access/logout.php?'><i class='feather icon-power'></i> Logout</a>\n";
				echo "</div>\n";
				echo "</ul>\n";
				echo "</div>\n";
				echo "</div>\n";
				echo "</div>\n";
				echo "</nav>\n";

				echo "<div class='horizontal-menu-wrapper'>\n";
				echo "<div class='header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-without-dd-arrow navbar-shadow menu-border' role='navigation' data-menu='menu-wrapper'>\n";
				echo "<div class='navbar-container main-menu-content' data-menu='menu-container'>\n";
				echo "<ul class='nav navbar-nav' id='main-menu-navigation' data-menu='menu-navigation'>\n";

				$i = 0;
				$account = $this->wa_get_apps($title, $applications, $sel_app);
				foreach($applications as $app)
				{
                    if ($_SESSION["wa_current_user"]->check_application_access($app))
                    {
						$acc = access_string($app->name);
						$class = ($account[3] == $app->id ? "active" : "");
						$n = count($app->modules);
						if ($n)
							$class .= " has-sub";
						$dashboard = "";	
					    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    					if (preg_match('/android/i', $u_agent) && preg_match('/mobile/i', $u_agent)) {
    						$link = "#'";
							$dashboard = "$local_path_to_root/index.php?application=$app->id";
						}
    					else
    						$link = "$local_path_to_root/index.php?application=$app->id '$acc[1]";

						echo "<li class='dropdown nav-item $class' data-menu='dropdown'><a class='dropdown-toggle nav-link' href='$link data-toggle='dropdown'><i class='feather icon-circle'></i><span data-i18n='Dashboard'>" . $acc[0] . "</span></a>\n";

						if (!$n)
						{
							echo "  </li>\n";
							continue;
						}	
						echo "<ul class='dropdown-menu'>\n";
   						if ($dashboard !="")

							echo "<li class='dropdown nav-item' data-menu='dropdown'><a class='dropdown-toggle' href='$dashboard' data-toggle='dropdown'><i class='feather icon-circle'></i><span data-i18n='Dashboard'>"._("Dashboard")."</span></a>\n";
						foreach ($app->modules as $module)
						{
	    					if (!$_SESSION["wa_current_user"]->check_module_access($module))
        						continue;

        					echo "<li class='dropdown dropdown-submenu' data-menu='dropdown-submenu'><a class='dropdown-item dropdown-toggle' href='#' data-toggle='dropdown' data-i18n='Analytics'><i class='feather icon-activity'></i><span>$module->name</span></a>\n";

 							$apps2 = array();
 							foreach ($module->lappfunctions as $appfunction)
								$apps2[] = $appfunction;
							foreach ($module->rappfunctions as $appfunction)
								$apps2[] = $appfunction;
							$application = array();	
       						$n = count($apps2);
       						$class = "";
       						if ($i > 5)
       							$class = "class='align_right'";
							if ($n)
								echo "        <ul class='dropdown-menu'>\n";
							else
							{
								echo "      </li>\n";
								continue;
							}	
							foreach ($apps2 as $application)	
							{
								$lnk = access_string($application->label);
								if ($_SESSION["wa_current_user"]->can_access_page($application->access))
								{
									if ($application->label != "")
									{

										echo "<li><a class='dropdown-item' href='$path_to_root/$application->link'><span>$lnk[0]</span></a>\n";
        					
									}
								}
								elseif (!$_SESSION["wa_current_user"]->hide_inaccessible_menu_items())	
									echo "";
							}
							if ($n)
								echo "        </ul>\n";	
							echo "      </li>\n";
						}
						echo "    </ul>\n"; // menu
					}
					echo"  </li>\n";
					$i++;
				}	
				echo "</ul>\n"; 
				echo "</div>\n";
				echo "</div>\n";
				echo "</div>\n";
				echo "</div>\n"; // MENU
			}
			if ($no_menu)
				echo "<br>";
			elseif ($title && !$no_menu && !$is_index)
			{
				echo "<div class='app-content content'>";
				echo "<div class='content-wrapper'>";
				echo "<div class='content-header row'>";
				echo "<div class='content-header-left col-md-9 col-12 mb-2'>";
				echo "<div class='row breadcrumbs-top'>";
				echo "<div class='col-12'>";
				echo "<div class='breadcrumb-wrapper col-12'>";
				echo "<ol class='breadcrumb'>";
				echo "<li class='breadcrumb-item'><h1 class='content-header-title float-left mb-0'>$title</h1>";
				echo "</li>";
				echo "</ol>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";

				echo "<div class='content-header-right text-md-right col-md-3 col-12 d-md-block d-none'>";
				echo "<div class='form-group breadcrum-right'>";
				echo "<div class='dropdown'>";
				echo "<a href='$path_to_root/admin/display_prefs.php?' class='btn-icon btn btn-primary btn-round btn-sm dropdown-toggle'><i class='feather icon-settings' style='color: #fff;' data-toggle='tooltip' data-placement='bottom' title='Preferences'></i></a>";

				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";

				echo "<section id='content-types'>\n";

				echo "<div class='card'>";
			}
		}

		function menu_footer($no_menu, $is_index)
		{
			global $path_to_root, $SysPrefs, $version, $db_connections;
			include_once($path_to_root . "/includes/date_functions.inc");

			if (!$no_menu && !$is_index)
				echo "</section>\n"; // fa-content
				echo "</div>\n"; // fa-content
				echo "</div>\n"; // fa-body
				echo "</div>\n"; // fa-body
				echo "</div>\n"; // fa-body
				echo "</div>\n"; // fa-body
			if (!$no_menu)
			{
				if (isset($_SESSION['wa_current_user']))
				{
				
				echo "<footer class='footer footer-static footer-light navbar-shadow'>
					<p class='clearfix blue-grey lighten-2 mb-0'><span class='float-md-left d-block d-md-inline-block mt-25'>COPYRIGHT &copy; 2021<a class='text-bold-800 grey darken-2' href='#' target='_blank'>" . $db_connections[$_SESSION["wa_current_user"]->company]["name"] . ",</a>All rights Reserved</span><span class='float-md-right d-none d-md-block'>Development By ".$SysPrefs->app_title." - Version $version</span>
					<button class='btn btn-primary btn-icon scroll-top' type='button'><i class='feather icon-arrow-up'></i></button>
					</p>
					</footer>";
				}
				echo "</div>\n"; // footer
			}
			echo "</div>\n"; // fa-main
		}

		function display_applications(&$waapp)
		{
			global $path_to_root;

			$sel = $waapp->get_selected_application();
			meta_forward("$path_to_root/admin/dashboard.php", "sel_app=$sel->id");	
        	end_page();
        	exit;
		}	
	}
	
