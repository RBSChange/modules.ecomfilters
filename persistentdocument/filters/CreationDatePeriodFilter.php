<?php
class ecomfilters_CreationDatePeriodFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$parameters = array();
		
		$info = new BeanPropertyInfoImpl('period', 'String');
		$info->setListId('modules_filter/dateperiods');
		$countParameter = new f_persistentdocument_DocumentFilterValueParameter($info);
		$parameters['period'] = $countParameter;
		
		$this->setParameters($parameters);
	}
	
	/**
	 * @return String
	 */
	public static function getDocumentModelName()
	{
		return 'modules_customer/customer';
	}

	/**
	 * @return f_persistentdocument_criteria_Query
	 */
	public function getQuery()
	{
		list($dateMin, $dateMax) = filter_DateFilterHelper::getDatesForPeriod($this->getParameter('period')->getValueForQuery());
		return customer_CustomerService::getInstance()->createQuery()->add(Restrictions::between("creationdate", $dateMin, $dateMax));
	}
	
	/**
	 * @param customer_persistentdocument_customer $value
	 */
	public function checkValue($value)
	{
		if ($value instanceof customer_persistentdocument_customer)
		{
			list($dateMin, $dateMax) = filter_DateFilterHelper::getDatesForPeriod($this->getParameter('period')->getValueForQuery());
			$creationdate = $value->getCreationdate();
			return (($dateMin < $creationdate) && ($dateMax > $creationdate));
		}
		return false;
	}
}
?>