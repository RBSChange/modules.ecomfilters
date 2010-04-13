<?php
class ecomfilters_LastCartUpdatePeriodFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$info = new BeanPropertyInfoImpl('count', 'Integer');
		$countParameter = new f_persistentdocument_DocumentFilterValueParameter($info);
		$parameters['count'] = $countParameter;
		
		$info = new BeanPropertyInfoImpl('unit', 'String');
		$info->setListId('modules_filter/dateunits');
		$countParameter = new f_persistentdocument_DocumentFilterValueParameter($info);
		$parameters['unit'] = $countParameter;
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
		$count = $this->getParameter('count')->getValueForQuery();
		$unit = $this->getParameter('unit')->getValueForQuery();
		$date = filter_DateFilterHelper::getReferenceDate($unit, $count);
		return customer_CustomerService::getInstance()->createQuery()->add(Restrictions::lt('lastCartUpdate', $date));
	}
	
	/**
	 * @param customer_persistentdocument_customer $value
	 */
	public function checkValue($value)
	{
		if ($value instanceof customer_persistentdocument_customer)
		{
			$count = $this->getParameter('count')->getValueForQuery();
			$unit = $this->getParameter('unit')->getValueForQuery();
			$date = filter_DateFilterHelper::getReferenceDate($unit, $count);
			return $value->getLastcartupdate() < $date;
		}
		return false;
	}
}