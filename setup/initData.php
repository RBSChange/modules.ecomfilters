<?php
/**
 * @package modules.ecomfilters.setup
 */
class ecomfilters_Setup extends object_InitDataSetup
{
	public function install()
	{
		$this->executeModuleScript('list.xml');
		$this->executeModuleScript('alerttypelist.xml');
	}

	/**
	 * @return String[]
	 */
	public function getRequiredPackages()
	{
		// Return an array of packages name if the data you are inserting in
		// this file depend on the data of other packages.
		// Example:
		// return array('modules_website', 'modules_users');
		return array();
	}
}
