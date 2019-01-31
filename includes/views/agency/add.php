<?php
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/database.php');
$data = new AgencyModel();
$users = $data->getUserAgency();

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
    <h3>Thêm mới đại lý</h3>

   <div class="agency">
       <form action="#" method="post">

           <div class="form-control">
               <label>Tên đại lý:</label>
               <input type="text" name="agency_name" placeholder="Tên đại lý">
           </div>
           <div class="form-control">
               <label>Địa chỉ</label>
               <input type="text" name="agency_address" placeholder="Địa chỉ"/>
           </div>
           <div class="form-control">
               <label>Số điện thoại</label>
               <input type="text" name="agency_phone" placeholder="Số điện thoại">
           </div>
           <div class="form-control">
               <label>Nhân viên phụ trách</label>
               <select name="agency_user">
                   <?php foreach ($users as $user) { ?>
                       <option value="<?php echo $user->ID ?>"><?php echo $user->display_name ?></option>
                   <?php } ?>
               </select>
           </div>
           <button>Thêm mới</button>
       </form>
   </div>
<?php
global $wpdb;
$agency_name_add = $_POST['agency_name'];
$agency_user_add = $_POST['agency_user'];
$agency_phone_add = $_POST['agency_phone'];
$agency_address_add = $_POST['agency_address'];
if ((trim($agency_name_add)) != '' && (trim($agency_user_add)) != '') {
    $wpdb->insert(
        $wpdb->base_prefix . 'woocommerce_agency',
        array(
            'agency_name' => $agency_name_add,
            'agency_user' => $agency_user_add,
            'agency_phone' => $agency_phone_add,
            'agency_address' => $agency_address_add
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%s'
        )
    );
    $_SESSION['messages'] = "Thêm thành công";
}
?>