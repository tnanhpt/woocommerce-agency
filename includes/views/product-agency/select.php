<?php
//global $wpdb;
$id_agency = $_GET['id'];
//$data = $wpdb->get_row("SELECT * FROM `{$wpdb->base_prefix}agency_product` WHERE agency_id = $id_agency ");
//$postdata = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}posts WHERE post_type = 'product' AND post_status = 'publish'" );
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
$model = new AgencyModel();
$data = $model->getProductAgencyByIdAgency($id_agency);
 ?>
<pre>
    <?php print_r($data) ?>
</pre>

<style>
    .btn-action,.btn-action:active {
        margin-left: 4px;
        padding: 4px 8px;
        position: relative;
        top: -3px;
        text-decoration: none;
        border: none;
        border: 1px solid #ccc;
        border-radius: 2px;
        background: #f7f7f7;
        text-shadow: none;
        font-weight: 600;
        font-size: 13px;
        line-height: normal;
        color: #0073aa;
        cursor: pointer;
        outline: 0;
    }

    .btn-action:focus {
        color: #124964;
    }
    .btn-action:hover {
        border-color: #008EC2;
        background: #00a0d2;
        color: #fff;
    }
</style>
<h3>Đại lý <?php echo $data->agency_name ?></h3>
<a href="?page=dai-ly-ban-hang&action=add-product-agency&id-agency=<?php echo $id_agency ?>" class="btn-action">Thêm mới</a>
<div class="agency">
    <table border="1">
        <thead>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Ngày tạo</th>
        <th>Thao tác</th>
        </thead>
        <tbody>
        <?php foreach ($data as $set) { ?>
            <tr>
                <td><?php echo $set->post_title ?></td>
                <td><?php echo $set->amount ?></td>

                <td><?php echo $set->create_at ?></td>
                <td class="btn-action"><a
                            href="?page=dai-ly-ban-hang&id-agency=<?php echo $id_agency ?>&id-product=<?php echo $set->id_amount ?>&action=edit-product-agency">Sửa</a>
                    <a
                            href="?page=dai-ly-ban-hang&id-agency=<?php echo $id_agency ?>&id-product=<?php echo $set->id_amount ?>&action=delete-product-agency">Xóa</a>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>