<?php
global $wpdb;
$id_agency = $_GET['id'];
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
$db = new AgencyModel();
$data = $db->getAgencyById($id_agency);
$users = $db->getUserAgency();
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

<h3>Quản lý đại lý</h3>
<div class="agency">
    <form action="#" method="post">
        <div class="form-control">
            <label>Tên đại lý:</label>
            <input type="text" value="<?php echo $data->agency_name ?>" name="agency_name" placeholder="Tên đại lý">
        </div>
        <div class="form-control">
            <label>Địa chỉ</label>
            <input type="text" value="<?php echo $data->agency_address ?>"  name="agency_address" placeholder="Địa chỉ"/>
        </div>
        <div class="form-control">
            <label>Số điện thoại</label>
            <input type="text" value="<?php echo $data->agency_phone ?>"  name="agency_phone" placeholder="Số điện thoại">
        </div>
        <div class="form-control">
            <label>Nhân viên phụ trách</label>
            <select name="agency_user" value="<?php echo $data->agency_user ?>" >
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->ID ?>" <?php echo $user->ID == $data->ID ? 'selected' : ''; ?>><?php echo $user->display_name ?> </option>

                <?php } ?>
            </select>
        </div>
        <button>Cập nhật</button>
    </form>
</div>
<?php
global $wpdb;
$id = $_GET['id'];
$agency_name = $_POST['agency_name'];
$agency_user = $_POST['agency_user'];
$agency_phone = $_POST['agency_phone'];
$agency_address = $_POST['agency_address'];
if (trim($agency_name) != '' && trim($agency_user) != '') {
    $wpdb->update(
        $wpdb->base_prefix . 'woocommerce_agency',
        array(
            'agency_name' => $agency_name,
            'agency_user' => $agency_user,
            'agency_phone' => $agency_phone,
            'agency_address' => $agency_address
        ),
        array(
            'agency_id' => $id
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%s'
        ),
        array(
            '%d'
        )
    );
}?>