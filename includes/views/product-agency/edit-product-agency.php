<?php
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
$model = new AgencyModel();
$id_product = $_GET['id-product'];
$data = $model->getProductAgencyById($id_product);
$id_agency = $_GET['id-agency'];
?>
    <style>
        .agency p {
            color: #0A246A;
            font-weight: bold;
        }
        .agency button {
            margin-top: 10px;
            padding: 6px 8px;
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
        .agency button:hover {
            border-color: #008EC2;
            background: #00a0d2;
            color: #fff;
        }
        .agency .form-control {
            display: flex !important;
            padding: 4px 8px;
            align-items: center;
        }

        .agency label {
            width: 150px;
            display: block;
        }

        .agency input, select {
            width: 300px;
            padding: 4px;
        }
    </style>
<div class="agency">

    <a href="?page=dai-ly-ban-hang&action=select-agency&id=<?php echo $id_agency ?>">←Quay lại</a>
    <form action="#" method="post">
        <div class="form-control">
            <label>Sản phẩm:</label>
            <input type="text" name="product" value="<?php echo $data->post_title?>" disabled>
        </div>
        <div class="form-control">
            <label>Số lượng hàng:</label>
            <input type="text" name="amount" placeholder="Nhập số lượng" value="<?php echo $data->amount?>">
        </div>
        <button>Cập nhật</button>
    </form>
</div>
<?php
global $wpdb;
$amount = $_POST['amount'];
echo $agency_name;
if (trim($amount) != '') {
    $wpdb->update(
        $wpdb->base_prefix.'agency_product',
        array(
            'amount' => $amount
        ),
        array(
            'id_amount' => $id_product
        ),
        array(
            '%d'
        ),
        array(
            '%d'
        )
    );
    $header = "Location: ?page=dai-ly-ban-hang&action=select-agency&id=$id_agency";
    echo $header;
    header("$header");
}
?>