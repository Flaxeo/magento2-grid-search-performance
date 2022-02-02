<?php

declare(strict_types=1);

namespace Flaxeo\GridSearchPerformance\Plugin;

use Magento\Framework\Api\Filter;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class StrictFieldsDataProvider
{
    /** @var ScopeConfigInterface */
    private $config;

    /** @var SerializerInterface */
    private $serializer;

    /** @var string */
    public const IS_STRICT_FIELDS_ENABLED_CONFIG_PATH = 'flaxeo_global_config/strictfields/is_enable';

    /** @var string */
    public const STRICT_FIELDS_LIST_CONFIG_PATH = 'flaxeo_global_config/strictfields/fields';

    public function __construct(
        ScopeConfigInterface $config,
        SerializerInterface $serializer
    ) {
        $this->config = $config;
        $this->serializer = $serializer;
    }

    public function beforeAddFilter(DataProvider $subject, Filter $filter): array
    {
        if (!$this->isStrictSearchEnabled()) {
            return [$filter];
        }

        $gridName = $subject->getName();
        $fieldName = $filter->getField();
        $isEnableForField = false;
        $enabledFields = $this->serializer->unserialize(
            $this->config->getValue(self::STRICT_FIELDS_LIST_CONFIG_PATH)
        );

        array_walk($enabledFields, function ($item, $key) use (&$isEnableForField, $gridName, $fieldName) {
            $isEnableForField = $isEnableForField ||
                $item['grid_name'] === $gridName && $item['field_name'] === $fieldName;
        });

        if ($isEnableForField === true) {
            $filter->setValue(str_replace('%', '', $filter->getValue()));
            $filter->setConditionType('eq');
        }

        return [$filter];
    }

    private function isStrictSearchEnabled(): bool
    {
        return (bool) $this->config->getValue(self::IS_STRICT_FIELDS_ENABLED_CONFIG_PATH);
    }
}
