<?php
class ecomfilters_CustomerInGroupCartFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$info = new BeanPropertyInfoImpl('group', BeanPropertyType::DOCUMENT, 'customer_persistentdocument_customergroup');
		$info->setLabelKey('&modules.ecomfilters.bo.documentfilters.parameter.Cart-customer-group;');
		$parameter = new f_persistentdocument_DocumentFilterValueParameter($info);
		$this->setParameter('group', $parameter);
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
			$param = $this->getParameter('group');
			foreach (explode(',', $param->getValue()) as $groupId)
			{
				$group = DocumentHelper::getDocumentInstance($groupId);
				if ($group->getDocumentService()->isMember($group, $value->getCustomer()))
				{
					return true;
				}
			}
		}
		return false;
	}
}