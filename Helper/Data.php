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
    const URL_API = 'https://aut01.ecommerce.creditea.com/app/api/merchants/transactions';
    const URL_BASE_POPUP = 'https://aut01.ecommerce.creditea.com/mx/apply/widget?amount=';
    const URL_BANNER_HOST = 'https://st67345.snleaders.pl';

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
    public function generateBannerUrl($placement = null)
    {
        $placement = !is_null($placement) ? strtolower($placement) : null;
        $placementMap = [
            'product_above_title' => 'banner_above_title.png',
            'product_below_price' => 'banner_below_price.png',
            'product_above_add_to_cart' => 'banner_above_addtocart.png',
            'product_below_description' => 'banner_below_description.png',
            'product_badge' => 'product_badge.png',
            'cart_below_summary' => 'banner_cart_below_summary.png',
            'checkout_below_summary' => 'checkout_below_summary.png',
            'promo_modal_content' => 'promo_modal_content.png',
        ];
        if(!is_null($placement) && isset($placementMap[$placement])){
            return Data::URL_BANNER_HOST . "/" . $placementMap[$placement] . '?t=' . time();
        }
        return Data::URL_BANNER_HOST . '/default.png?t=' . time();
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

    public function isEnableBannerAtCheckout()
    {
        return $this->getConfigValue('payment/creditea_magento2/enable_banner_at_checkout') ?? 0;
    }
    
    public function isEnableBannerAtCart()
    {
        return $this->getConfigValue('payment/creditea_magento2/enable_banner_at_cart') ?? 0;
    }

}
