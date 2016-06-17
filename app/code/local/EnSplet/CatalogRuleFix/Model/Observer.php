<?php
 
class EnSplet_CatalogRuleFix_Model_Observer extends Mage_CatalogRule_Model_Observer
{
    public function dailyCatalogUpdate($observer)
    {
        $collection = Mage::getResourceModel('catalogrule/rule_collection')
            ->addFieldToFilter('is_active', array('neq' => 0));
        if ($collection->getSize() == 0) {
            return $this;
        }
        parent::dailyCatalogUpdate($observer);
        $types = Mage::getConfig()->getNode('global/catalogrule/related_cache_types')->asArray();
        foreach (array_keys($types) as $type) {
            Mage::app()->getCacheInstance()->cleanType($type);
        }
        return $this;
    }
}
