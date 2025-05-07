<?php
namespace Creditea\Magento2\Controller\Banner;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Creditea\Magento2\Helper\Data;

class GetUrl extends Action
{
    protected $resultJsonFactory;
    protected $helper;
    
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Data $helper
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper = $helper;
    }
    
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        
        try {
            $position = $this->getRequest()->getParam('position', 'default');
            $isEnabled = false;
            switch ($position) {
                case 'checkout_below_summary':
                    $position = 'checkout_below_summary';
                    $isEnabled = $this->helper->isEnableBannerAtCheckout();
                    break;
                default:
                    $position = 'default';
                    $isEnabled = true;
                    break;
            }
            $bannerUrl = $this->helper->generateBannerUrl($position);
            return $result->setData(['url' => $bannerUrl, 'isEnabled' => $isEnabled]);
        } catch (\Exception $e) {
            return $result->setData(['error' => $e->getMessage()]);
        }
    }
}