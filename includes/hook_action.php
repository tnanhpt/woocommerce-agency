<?php
include_once("model/database.php");
include_once("model/agency.model.php");

function add_menu_agency()
{
    add_menu_page('Tất cả đại lý', 'Đại lý', 'edit_products', 'dai-ly-ban-hang', 'reseller_page', 'dashicons-admin-multisite', '57');
    add_submenu_page('dai-ly-ban-hang', 'Tất cả đại lý', 'Tất cả đại lý', 'edit_products', 'dai-ly-ban-hang', 'reseller_page');
    add_submenu_page('dai-ly-ban-hang', 'Thêm mới đại lý', 'Thêm mới đại lý', 'edit_products', 'add-agency', 'addAgencyLayout');
}

add_action('admin_menu', 'add_menu_agency');
function reseller_page()
{
    switch ($_GET['action']) {
        case 'add-product-agency':
            {
                include('views/product-agency/add-product-agency.php');
                break;
            }
        case 'select-agency':
            {

                include 'views/product-agency/list-product-agency.php';
                break;
            }
        case 'edit-agency':
            {
                include 'views/agency/edit.php';
                break;
            }
        case 'delete-agency':
            {
                include 'views/agency/delete.php';
                break;
            }
        case 'add-agency':
            {
                include 'views/agency/add.php';
                break;
            }
        case 'add-product-agency':
            {
                include 'views/product-agency/add-product-agency.php';
                break;
            }
        case 'edit-product-agency':
            {

                include 'views/product-agency/edit-product-agency.php';
                break;
            }
        case 'delete-product-agency':
            {
                global $wpdb;
                $id = $_GET['id-product'];
                $id_agency = $_GET['id-agency'];
                $wpdb->delete($wpdb->base_prefix . 'agency_product', array('id_amount' => $id));

                $url = "Location: ?page=dai-ly-ban-hang&action=select-agency&id=$id_agency";
                header($url);
                break;
            }
        case 'test':
            {
                include 'views/product-agency/test.php';
                break;
            }
        default:
            {

                include 'views/agency/list-product.php';
                break;
            }
    }
}

function addAgencyLayout()
{

    include("views/agency/add.php");


}

add_action('woocommerce_admin_order_data_after_order_details', 'add_agency_order');

function add_agency_order($order)
{
    require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
    $model = new AgencyModel();
    $data = $model->getNameAgency();
    $agency = array();
    foreach ($data as $value) {
        $agency[$value[0]] = $value[1];
    }
    ?>
    <br class="clear"/>
    <h4>Đại lý giao hàng <a href="#" class="edit_address">Sửa</a></h4>
    <?php
    $is_agency = get_post_meta($order->id, 'is_agency', true);
    $agency_id = get_post_meta($order->id, 'agency_id', true);
    $agency_note = get_post_meta($order->id, 'agency_note', true);
    $agency_order_status = get_post_meta(($order->id), 'agency_order_status', true);
    ?>
    <div class="address">
        <p><strong>Thiết lập đại lý giao hàng</strong><?php echo $is_agency ? 'Có' : 'Không' ?></p>
        <?php
        if ($is_agency) {
            $agency_data = $model->getAgencyById($agency_id);
            ?>
            <p><strong>Tên đại lý:</strong> <?php echo $agency_data->agency_name ?></p>
            <?php if (trim($agency_note) != '') { ?>
                <p><strong>Ghi chú:</strong> <?php echo wpautop($agency_note) ?></p>
            <?php } ?>
            <?php if (trim($agency_order_status) != '') { ?>
                <p><strong>Tình trạng:</strong> <?php echo $agency_order_status ?></p>
            <?php }
        } ?>
    </div>
    <div class="edit_address"><?php

        woocommerce_wp_radio(array(
            'id' => 'is_agency',
            'label' => 'Bạn có muốn thiết lập đại lý giao hàng không?',
            'value' => $is_agency,
            'options' => array(
                '' => 'Không',
                '1' => 'Có'
            ),
            'style' => 'width:16px',
            'wrapper_class' => 'form-field-wide'
        ));

        woocommerce_wp_select(array(
            'id' => 'agency_id',
            'label' => 'Tên đại lý:',
            'value' => $agency_id,
            'options' => $agency,
            'wrapper_class' => 'form-field-wide'
        ));
        woocommerce_wp_textarea_input(array(
            'id' => 'agency_note',
            'label' => 'Ghi chú cho đại lý:',
            'value' => $agency_note,
            'wrapper_class' => 'form-field-wide'
        ));

        ?></div>


<?php }

add_action('woocommerce_admin_order_data_after_order_details', 'is_subtract_product');

function is_subtract_product($order)
{
    $is_agency = get_post_meta($order->id, 'is_agency', true);
    $subtract_product = get_post_meta($order->id, 'subtract_product', true);
    woocommerce_wp_checkbox(array(
        'id' => 'subtract_product',
        'style' => 'width: fit-content',
        'value' => $subtract_product,
        'wrapper_class' => 'form-field-wide',
        'label' => __('<h4>Trừ số lượng sản phẩm của đại lý hiện có</h4>'),
        'description' => __('Chọn để trừ (chỉ có hiệu lực khi đơn hàng không ở trạng thái hoàn thành)')
    ));
}

add_action('woocommerce_process_shop_order_meta', 'misha_save_general_details1');

function misha_save_general_details1($ord_id)
{
    update_post_meta($ord_id, 'is_agency', wc_clean($_POST['is_agency']));
    update_post_meta($ord_id, 'agency_id', wc_clean($_POST['agency_id']));
    $woocommerce_checkbox = isset($_POST['subtract_product']) ? 'yes' : 'no';
    update_post_meta($ord_id, 'subtract_product', $woocommerce_checkbox);
    update_post_meta($ord_id, 'agency_note', wc_sanitize_textarea($_POST['agency_note']));

}

add_action('woocommerce_order_status_changed', 'product_agency_manager_order', 9999, 3);
function product_agency_manager_order($order_id, $old_status, $new_status)
{
    require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
    $db = new AgencyModel();
    $order = wc_get_order($order_id);
    $items = $order->get_items();
    $is_agency = get_post_meta($order_id, 'is_agency', true);
    $agency_id = get_post_meta($order_id, 'agency_id', true);
    $agency_name = $db->getAgencyNameById($agency_id);
    $subtract_product = get_post_meta($order_id, 'subtract_product', true);
    if ($is_agency && $new_status == "completed") {
        update_post_meta($order_id, 'agency_order_status', wc_clean('Chưa trừ lượng sản phẩm trong đại lý tương đương với đơn hàng'));
        if ($subtract_product == 'yes') {
            $pass = false;
            foreach ($items as $item) {
                $product_id = $item->get_product_id();
                $quantity = $item->get_quantity();

                $query = $db->getAmountProductByIdProductAndAgencyId($product_id, $agency_id);
                $amount_agency = $query->amount;
                $check = $db->checkExistProductAgency($product_id, $agency_id);
                if ($check->isExisted == 1 && $amount_agency >= $quantity) {
                    $pass = true;
                } else {
                    $pass = false;
                    update_post_meta($order_id, 'agency_order_status', wc_clean('Sản phẩm ' . $item->get_name() . ' không đủ hàng hoặc không tồn tại'));
                    $order->add_order_note('<span style="color:red">Sản phẩm <b>' . $item->get_name() . '</b> tại đại lý <b>' . $agency_name->agency_name . '</b> không đủ hàng hoặc không tồn tại</span>');
                    $order->update_status('wc-not-enough-goods');
                    update_post_meta($order_id, 'subtract_product', 'no');
                    break;
                }
            }
            if ($pass) {
                foreach ($items as $item) {
                    $product_id = $item->get_product_id();
                    $quantity = $item->get_quantity();
                    $query = $db->getAmountProductByIdProductAndAgencyId($product_id, $agency_id);
                    $amount_agency = $query->amount;
                    $amount_new = $amount_agency - $quantity;
                    $db->subtract_product_amount($product_id, $agency_id, $amount_new);
                }
                update_post_meta($order_id, 'agency_order_status', wc_clean('Đã trừ số lượng sản phẩm cho đại lý tương tương đơn hàng'));
                update_post_meta($order_id, 'subtract_product', 'no');
            }
        } else {
            update_post_meta($order_id, 'agency_order_status', wc_clean(''));
        }
    }
}

//function general_admin_notice()
//{
//    global $pagenow;
//    if ($pagenow == 'post.php') {
//        echo '<div class="notice notice-warning is-dismissible">
//             <p>Đây là trang bài post</p>
//         </div>';
//    }
//}
//add_action('admin_notices', 'general_admin_notice');
?>

