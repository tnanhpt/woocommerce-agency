<?php
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
$model = new AgencyModel();
$id_agency = $_GET['id-agency'];
$products = $model->getAllProductNotExisted($id_agency);
$agency = $model->getAgencyById($id_agency);
?>

<style>
    p {
        color: #0A246A;
        font-weight: bold;
    }

    button {
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

    .form-control {
        display: flex !important;
        padding: 4px 8px;
        align-items: center;
    }

    label {
        width: 150px;
        display: block;
    }

    input, select {
        width: 300px;
        padding: 4px;
    }
</style>
<h3>Thêm sản phẩm cho đại lý: <?php echo $agency->agency_name ?></h3>
<a href="?page=dai-ly-ban-hang&action=select-agency&id=<?php echo $id_agency ?>">←Quay lại</a>
<div class="agency">
    <form action="#" method="post">
        <div class="form-control">
            <label>Sản phẩm</label>
            <select name="post_id">
                <?php foreach ($products as $product) { ?>
                    <option value="<?php echo $product->ID ?>"><?php echo $product->post_title ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-control">
            <label>Số lượng hàng:</label>
            <input type="text" name="amount" placeholder="Nhập số lượng">
        </div>
        <button>Thêm mới</button>
    </form>
</div>
<?php
global $wpdb;
$post_id= $_POST['post_id'];
$amount = $_POST['amount'];
if ($post_id !== '') {
    $wpdb->insert(
        $wpdb->base_prefix . 'agency_product',
        array(
            'post_id' => $post_id,
            'amount' => $amount,
            'agency_id' => $agency->agency_id
        ),
        array(
            '%s',
            '%d',
            '%d'
        )
    );
}
?>