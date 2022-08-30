<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Tweakwise\AttributeLandingTweakwise\Model\FilterApplier;

use Tweakwise\AttributeLanding\Api\Data\LandingPageInterface;
use Tweakwise\AttributeLanding\Model\FilterApplier\FilterApplierInterface;
use Tweakwise\Magento2Tweakwise\Model\Catalog\Layer\NavigationContext;

class TweakwiseFilterApplier implements FilterApplierInterface
{
    /**
     * @var NavigationContext
     */
    private $navigationContext;

    /**
     * TweakwiseFilterApplier constructor.
     * @param NavigationContext $navigationContext
     */
    public function __construct(NavigationContext $navigationContext)
    {
        $this->navigationContext = $navigationContext;
    }

    /**
     * @param LandingPageInterface $page
     * @return mixed
     */
    public function applyFilters(LandingPageInterface $page)
    {
        $navigationRequest = $this->navigationContext->getRequest();

        $filters = $page->getFilters();

        foreach ($filters as $filter) {
            $navigationRequest->addAttributeFilter($filter->getFacet(), $filter->getValue());
        }

        if ($filterTemplateId = $page->getTweakwiseFilterTemplate()) {
            $navigationRequest->setTemplateId($filterTemplateId);
        }

        if ($sortTemplateId = $page->getTweakwiseSortTemplate()) {
            $navigationRequest->setSortTemplateId($sortTemplateId);
        }
    }

    /**
     * @return bool
     */
    public function canApplyFilters(): bool
    {
        return true;
    }
}
