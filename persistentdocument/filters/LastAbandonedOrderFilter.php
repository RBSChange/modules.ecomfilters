<?php
class ecomfilters_LastAbandonedOrderFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$parameters = array();
		$model = f_persistentdocument_PersistentDocumentModel::getInstanceFromDocumentModelName("modules_customer/customer");
		$info = $model->getBeanPropertyInfo('lastAbandonedOrderDate');
		$dateParameter = f_persistentdocument_DocumentFilterRestrictionParameter::getNewInstance($info);
		$parameters['date'] = $dateParameter;
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
		return customer_CustomerService::getInstance()->createQuery()->add($this->getParameter('date')->getValueForQuery());
	}
	
	/**
	 * @param customer_persistentdocument_customer $value
	 */
	public function checkValue($value)
	{
		if ($value instanceof customer_persistentdocument_customer)
		{
			$param = $this->getParameter('date');
			$restriction = $param->getRestriction();
			$val = $param->getParameter()->getValue();
			$testVal = $this->getTestValueForPropertyName($val, 'lastAbandonedOrderDate');
			return $this->evalRestriction($testVal, $restriction, $val);
		}
		return false;
	}
}