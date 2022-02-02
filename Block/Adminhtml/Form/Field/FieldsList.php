<?php
declare(strict_types=1);

namespace Flaxeo\GridSearchPerformance\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class FieldsList extends AbstractFieldArray
{
    protected function _prepareToRender(): void
    {
        $this->addColumn('grid_name', [
            'label' => __('Grid name'),
            'class' => 'required-entry'
        ]);

        $this->addColumn('field_name', [
            'label' => __('Field name'),
            'class' => 'required-entry'
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
