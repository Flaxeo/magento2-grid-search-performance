# Flaxeo GridSearchPerformance

Extension to optimize admin grid search by adding ability of define strict field for search.
Each fields provided will use strict sql query :
myfield = 'myrequest'
instead of
myfield LIKE '%myrequest%'

To configure you need to retrieve datasourceprovider (on uicomponent xml) name of the grid and field_name
eg:
- customer_listing_data_source (vendor/magento/module-customer/view/adminhtml/ui_component/customer_listing.xml)
- sales_order_invoice_grid_data_source (vendor/magento/module-sales/view/adminhtml/ui_component/sales_order_invoice_grid.xml)
- sales_order_shipment_grid_data_source
- sales_order_grid_data_source

field_name is related to entity, eg for customer : "email"
