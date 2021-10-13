<?php

class dimensions_app extends application
{
	function __construct()
	{
		$dim = get_company_pref('use_dimension');
		parent::__construct("proj", _($this->help_context = "&Departement"), $dim);

		if ($dim > 0)
		{
			$this->add_module(_("Menus Departement"));
			$this->add_lapp_function(0, _("Departement &New"),
				"dimensions/dimension_entry.php?", 'SA_DIMENSION', MENU_ENTRY);
			$this->add_lapp_function(0, _("&Outstanding Departement"),
				"dimensions/inquiry/search_dimensions.php?outstanding_only=1", 'SA_DIMTRANSVIEW', MENU_TRANSACTION);

			$this->add_module(_("List and Reports"));
			$this->add_lapp_function(1, _("Departement &Inquiry"),
				"dimensions/inquiry/search_dimensions.php?", 'SA_DIMTRANSVIEW', MENU_INQUIRY);

			$this->add_rapp_function(1, _("Departement &Reports"),
				"reporting/reports_main.php?Class=4", 'SA_DIMENSIONREP', MENU_REPORT);
			
			$this->add_module(_("Maintenance"));
			$this->add_lapp_function(2, _("Departement &Tags"),
				"admin/tags.php?type=dimension", 'SA_DIMTAGS', MENU_MAINTENANCE);

			$this->add_extensions();
		}
	}
}

