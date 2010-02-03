<?php
class ecomfilters_CustomerPropertyCartFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$amountParameter = f_persistentdocument_DocumentFilterRestrictionParameter::getNewInstance();
		$amountParameter->setAllowedPropertyNames(array(
			'modules_customer/customer.creationdate',
			'modules_customer/customer.canBeTrusted',
			'modules_customer/customer.tarifGroup',
			'modules_users/websitefrontenduser.firstname',
			'modules_users/websitefrontenduser.lastname',
			'modules_users/websitefrontenduser.email',
			'modules_users/websitefrontenduser.login'
		));
		
		$beanprop = new BeanPropertyInfoImpl('usedCoupon', 'modules_marketing/coupon');
		$beanprop->setMaxOccurs(-1);	
		$amountParameter->addAllowedProperty('modules_customer/customer.usedCoupon', $beanprop);
			
		$this->setParameters(array('field' => $amountParameter));
	}
	
	/**
	 * @return String
	 */
	public static function getDocumentModelName()
	{
		return 'order/cart';
	}
	
	/**
	 * @param order_CartInfo $value
	 */
	public function checkValue($value)
	{
		if ($value instanceof order_CartInfo)
		{
			$param = $this->getParameter('field');
			$testVal = $this->getTestVal($param, $value);
			$restriction = $param->getRestriction();
			$val = $param->getParameter()->getValue();
			return $this->evalRestriction($testVal, $restriction, $val);
		}
		return false;
	}
	
	/**
	 * @param f_persistentdocument_DocumentFilterRestrictionParameter $paremeter
	 * @param order_CartInfo $value
	 * @return mixed
	 */
	private function getTestVal($parameter, $value)
	{
		list($model, $propertyName) = explode('.', $parameter->getPropertyName());
		if ($model === "modules_customer/customer")
		{
			$customer = $value->getCustomer();
			return $this->getTestValueForPropertyName($customer, $propertyName);
		}
		else if ($model === "modules_users/websitefrontenduser")
		{
			$user = $value->getCustomer()->getUser();
			return $this->getTestValueForPropertyName($user, $propertyName);
		}
		return null;
	}
}