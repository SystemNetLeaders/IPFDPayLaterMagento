<?php
namespace Creditea\Magento2\Block\Catalog\Product;

use Creditea\Magento2\Helper\Log;
use Creditea\Magento2\Helper\Data;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;

class View extends AbstractProduct
{    
    Protected $helper;
    protected $context;
    protected $helperLog;

    public function __construct(
        Data $helper,
        Log $helperLog,
        Context $context, 
        array $data
    ){
        parent::__construct($context, $data);
        $this->helperLog = $helperLog;
        $this->helper = $helper;
    }

    function canShow($skipProductCheck = false){
        /* If payment is disable */
        if(!$this->helper->isEnable()){
            return false;
        }

        /* If lost apikey */
        if($this->helper->getApiKey() == ''){
            $this->helperLog->log(__('API key is required'));
            return false;
        }
        
        /* Init out catalog_product_view */
        if($skipProductCheck == false){
            if(!$this->helper->getCurrentProduct()){
                return false;
            }
        }

        return true;
    }

    function getCurrentProductPrice(){
        $finalPrice = 0;
        try {
            $price = $this->getProduct()->getPriceInfo()->getPrice(\Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE)->getAmount();
            $finalPrice = $price->getValue();
        } catch (\Throwable $th) {
            $this->helperLog->log($th);
        }
        return $finalPrice; 
    }

    function getUrlCreditea(){
        $price = $this->getCurrentProductPrice();
        return Data::URL_BASE_POPUP . $price;
    }

    function getPesosQuincenalesFormatted(){
        $quincenas = Data::QUINCENAS;
        $minCalculatePrice = Data::MIN_CALCULATE_PRICE;
        $price = $this->getCurrentProductPrice();
        $pesosQuincenales = $this->getEstimatedInstallment($price, $quincenas);
            if($minCalculatePrice > $pesosQuincenales){
                $pesosQuincenales = $minCalculatePrice; 
            }
        return "$".number_format($pesosQuincenales, 2, ".", ",");
    }

    function getEstimatedInstallment($orderAmount, $biweekly = 60) {
        $netMonthlyRate = 0.0299;
        $grossRate = $netMonthlyRate * 1.16;
        $anualInterestRate = $grossRate * 12;
        $numberOfBiweeklyRates = $biweekly;
    
        return $this->calculatePayment(
            $anualInterestRate / 24,
            $numberOfBiweeklyRates,
            $orderAmount
        );
    }

    function calculatePayment($interestRate, $numberOfPayments, $principalAmount) {
        $term = pow((1 + $interestRate), $numberOfPayments);
        return ($principalAmount * $interestRate * $term) / ($term - 1);
    }

    function getBrandUrl(){
        return $this->getViewFileUrl('Creditea_Magento2::images/creditea_pay_default.png');
    }

    function isCurrentProductPriceInRange(){
        $price = $this->getCurrentProductPrice();
        $minPrice = $this->helper->getMinPrice();
        $maxPrice = $this->helper->getMaxPrice();
        if($price >= $minPrice && $price <= $maxPrice){
            return true;
        }
        return false;
    }

    function getBannerUrl($placement = null){
        return $this->helper->generateBannerUrl($placement);
    }

    public function showImageAboveTitle() // Works
    {
        return $this->helper->isEnableImageAboveTitle();
    }
    public function showImageBelowPrice() // Works
    {
        return $this->helper->isEnableImageBelowPrice();
    }
    public function showImageAboveAddToCart() // Works
    {
        return $this->helper->isEnableImageAboveAddToCart();
    }
    public function showImageBelowDescription()
    {
        return $this->helper->isEnableImageBelowDescription();
    }
    public function showBadgeOverlay()
    {
        return $this->helper->isEnableBadgeOverlay();
    }
    public function showBannerCheckout()
    {
        return $this->helper->isEnableBannerAtCheckout();
    }
    public function showBannerCart()
    {
        return $this->helper->isEnableBannerAtCart();
    }

}
