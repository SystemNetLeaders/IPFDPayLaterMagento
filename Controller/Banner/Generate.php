<?php
namespace Creditea\Magento2\Controller\Banner;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Creditea\Magento2\Helper\Data;

class Generate extends Action
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
            $bannerUrl = $this->helper->generateBannerUrl();
            return $result->setData(['url' => $bannerUrl]);
        } catch (\Exception $e) {
            return $result->setData(['error' => $e->getMessage()]);
        }
    }
}