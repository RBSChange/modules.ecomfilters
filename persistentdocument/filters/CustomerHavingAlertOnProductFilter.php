<?php
class ecomfilters_CustomerHavingAlertOnProductFilter extends f_persistentdocument_DocumentFilterImpl
{
	public function __construct()
	{
		$info = new BeanPropertyInfoImpl('product', BeanPropertyType::DOCUMENT, 'catalog_persistentdocument_product');
		$info->setLabelKey('&modules.ecomfilters.bo.documentfilters.parameter.Product;');
		$parameter = new f_persistentdocument_DocumentFilterValueParameter($info);
		$this->setParameter('product', $parameter);
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
		$query = customer_CustomerService::getInstance()->createQuery();
		$subQuery1 = $query->createCriteria('user');
		$subQuery2 = $subQuery1->createPropertyCriteria('userId', 'modules_catalog/alert');
		$subQuery2->add(Restrictions::in('productId', DocumentHelper::getIdArrayFromDocumentArray($this->getParameter('product')->getValueForQuery())));
		return $query;
	}
	
	/**
	 * @param customer_persistentdocument_customer $value
	 */
	public function checkValue($value)
	{
		if ($value instanceof customer_persistentdocument_customer)
		{
			$products = $this->getParameter('product')->getValueForQuery();
			return catalog_AlertService::getInstance()->hasPublishedByUserAndProductIds($value->getUser(), DocumentHelper::getId($products));		
		}
		return false;
	}
}