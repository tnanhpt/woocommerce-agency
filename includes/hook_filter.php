<?php
function sv_wc_cogs_add_order_profit_column_header($columns)
{

    $new_columns = array();

    foreach ($columns as $column_name => $column_info) {

        $new_columns[$column_name] = $column_info;

        if ('order_status' === $column_name) {
            $new_columns['order_agency'] = __('Đại lý giao hàng', 'order_agency-text');
        }
        if ('order_status' === $column_name) {
            $new_columns['order_payment_method'] = __('Phương thức thanh toán', 'order_agency-text');
        }
    }
    return $new_columns;
}

add_filter('manage_edit-shop_order_columns', 'sv_wc_cogs_add_order_profit_column_header', 20);
add_action('manage_shop_order_posts_custom_column', 'snv_custom_shop_order_column', 10, 2);
function snv_custom_shop_order_column($column)
{
    global $post, $woocommerce, $the_order, $order;
    require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
    $model = new AgencyModel();
    switch ($column) {
        case 'order_agency':
            $id_agency = get_post_meta($post->ID, 'agency_id', true);
            $agency_name = $model->getAgencyNameById($id_agency);
            echo $agency_name->agency_name;
            break;
        case 'order_payment_method':
            $payment_method = $the_order->get_payment_method_title();
            echo $payment_method;
            break;
    }
}
function reg_status_not_enough_product() {
    register_post_status( 'wc-not-enough-goods', array(
        'label' => _x( 'Đại lý không có hoặc thiếu hàng', 'Đại lý không có hoặc thiếu hàng', 'not-enough' ),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop( 'Approved (%s)', 'Approved (%s)', 'not-enough' )
    ) );
}
add_filter( 'init', 'reg_status_not_enough_product' );


function add_status_not_enough_product( $order_statuses ) {
    $order_statuses['wc-not-enough-goods'] = _x( 'Đại lý không có hoặc thiếu hàng', 'WooCommerce Order status', 'not-enough' );
    return $order_statuses;
}
add_filter( 'wc_order_statuses', 'add_status_not_enough_product' );

//function reg_status_not_existed_product() {
//register_post_status( 'wc-not-existed-goods', array(
//    'label' => _x( 'Đại lý không có sản phẩm', 'Đại lý không có sản phẩm', 'not-existed' ),
//    'public' => true,
//    'exclude_from_search' => false,
//    'show_in_admin_all_list' => true,
//    'show_in_admin_status_list' => true,
//    'label_count' => _n_noop( 'Approved (%s)', 'Approved (%s)', 'not-existed' )
//) );
//}
//add_filter( 'init', 'reg_status_not_existed_product' );
//
//
//function add_status_not_existed_product( $order_statuses ) {
//    $order_statuses['wc-not-existed-goods'] = _x( 'Đại lý không có sản phẩm', 'Đại lý không có sản phẩm', 'not-existed' );
//    return $order_statuses;
//}
//add_filter( 'wc_order_statuses', 'add_status_not_existed_product' );