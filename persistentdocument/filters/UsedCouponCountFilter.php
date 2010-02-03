<?php
class ecomfilters_UsedCouponCountFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$parameters = array();

		$info = new BeanPropertyInfoImpl('count', 'Integer');
		$parameter = f_persistentdocument_DocumentFilterRestrictionParameter::getNewHavingInstance($info);
		$parameters['count'] = $parameter;
		
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
		$query = customer_CustomerService::getInstance()->createQuery()->setFetchColumn('this');
		$query->createCriteria('usedCoupon')->setProjection(Projections::rowCount('count'));
		$query->having($this->getParameter('count')->getValueForQuery());
		return $query;
	}
	
	/**
	 * @param customer_persistentdocument_customer $value
	 */
	public function checkValue($value)
	{
		if ($value instanceof customer_persistentdocument_customer)
		{
			$countParameter = $this->getParameter('count');
			return $this->evalRestriction($countParameter->getParameter()->getValue(), $countParameter->getRestriction(), $value->getUsedCouponCount());
		}
		return false;
	}
}
?>