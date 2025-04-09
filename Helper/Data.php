<?php
namespace Creditea\Magento2\Helper;

use Magento\Framework\Registry;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Encryption\EncryptorInterface;

class Data extends AbstractHelper
{
    const QUINCENAS = 60;
    const MIN_CALCULATE_PRICE = 200;
    const URL_API = 'https://ecommerce.creditea.com/app/api/merchants/transactions';
    const URL_BASE_POPUP = 'https://ecommerce.creditea.com/mx/apply/widget?amount=';

	protected $storeManager;
    protected $registry;
	protected $context;
    protected $enc;

    public function __construct(
		Context $context,
		Registry $registry,
        EncryptorInterface $enc,
        StoreManagerInterface $storeManager
    ) {
		parent::__construct($context);
		$this->storeManager = $storeManager;
		$this->registry = $registry;
        $this->enc = $enc;
    }

    public function getStoreData($storeId = null)
    {
        if($storeId != null){
            return $this->storeManager->getStore($storeId);
        }
        return $this->storeManager->getStore();
    }

	public function getStoreId()
    {
        return $this->getStoreData()->getId();
	}

	public function getConfigValue($field, $storeId = null)
	{
		$IdStore = ($storeId == null ? $this->getStoreId() : $storeId);
		return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $IdStore);
	}

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function isEnable()
    {
        return $this->getConfigValue('payment/creditea_magento2/active') ?? 0;
    }

    public function getApiKey()
    {
        $getToken = $this->getConfigValue('payment/creditea_magento2/api_key_production');
        return $this->enc->decrypt($getToken);
    }

    public function isEnableImageAboveTitle()
    {
        return $this->getConfigValue('payment/creditea_magento2/enable_image_above_title') ?? 0;
    }

    public function isEnableImageBelowPrice()
    {
        return $this->getConfigValue('payment/creditea_magento2/enable_image_below_price') ?? 0;
    }

    public function isEnableImageAboveAddToCart()
    {
        return $this->getConfigValue('payment/creditea_magento2/enable_image_above_addtocart') ?? 0;
    }

    public function isEnableImageBelowDescription()
    {
        return $this->getConfigValue('payment/creditea_magento2/enable_image_below_description') ?? 0;
    }

    public function isEnableBadgeOverlay()
    {
        return $this->getConfigValue('payment/creditea_magento2/enable_badge_overlay') ?? 0;
    }
}
