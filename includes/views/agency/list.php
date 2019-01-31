<!---->
<?php
//require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
//require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
//
//class AgencyListTableClass extends WP_List_Table
//{
//    public function data($orderBy = "", $order = "", $searchTerm = "")
//    {
//        $model = new AgencyModel();
//        if (!empty($searchTerm)) {
//            return $model->searchAgency($searchTerm);
//        } else {
//            switch ($orderBy) {
//                case 'agency_name':
//                    {
//                        if ($order === "desc") {
//                            return $model->getAllAgencySort('agency_name', 'desc');
//                        }
//                        if ($order === 'asc') {
//                            return $model->getAllAgencySort('agency_name', 'asc');
//                        }
//                        break;
//                    }
//                case 'create_at':
//                    {
//                        if ($order === "desc") {
//                            return $model->getAllAgencySort('create_at', 'desc');
//                        }
//                        if ($order === 'asc') {
//                            return $model->getAllAgencySort('create_at', 'asc');
//                        }
//                        break;
//                    }
//                default:
//                    {
//                        return $data = $model->getAllAgency();
//
//
//                    }
//
//            }
//        }
//
////        return json_decode($model->getAllAgency(), true);
//    }
//
////  chuẩn bị dữ liệu
//    public function prepare_items()
//    {
//        $orderBy = isset($_GET['orderby']) ? trim($_GET['orderby']) : "";
//        $order = isset($_GET['order']) ? trim($_GET['order']) : "";
//        $serchTerm = isset($_POST['s']) ? trim($_POST['s']) : "";
//        $data = json_decode(json_encode($this->data($orderBy, $order, $serchTerm)), true);
//        $per_page = 3;
//        $current_page = $this->get_pagenum();
//        $toltal_items = count($data);
//        $this->set_pagination_args(array(
//            "total_items" => $toltal_items,
//            "per_page" => $per_page,
//
//        ));
//
//
//        $this->items = array_slice($data, (($current_page - 1) * $per_page), $per_page);
//        $columns = $this->get_columns();
//        $hiddens = $this->get_hidden_columns();
//        $sortable = $this->get_sortable_columns();
//
//
//        $this->_column_headers = array($columns, $hiddens, $sortable);
//    }
//
//
//    public function get_columns()
//    {
//        $columns = array(
//            "agency_id" => "ID",
//            "agency_name" => "Tên đại lý",
//            "agency_user" => "Chủ đại lý",
//            "agency_address" => "Địa chỉ",
//            "agency_phone" => "Số điện thoại",
//            "create_at" => "Thời gian"
//        );
//        return $columns;
//    }
//
//    public function column_default($item, $column_name)
//    {
//        $item_json = json_decode(json_encode($item), true);
//        switch ($column_name) {
//            case 'agency_id':
//            case 'agency_name':
//            case 'agency_user':
//            case 'agency_address':
//            case 'agency_phone':
//            case 'create_at':
//                return $item_json[$column_name];
//            default:
//                return 'no value';
//        }
//    }
//
//    public function get_hidden_columns()
//    {
//        return array('');
//    }
//
//    public function get_sortable_columns()
//    {
//        return array(
//            "agency_name" => array("agency_name", true),
//            "create_at" => array("create_at", false)
//        );
//    }
//
//    public function column_title($item)
//    {
//        $item_json = json_decode(json_encode($item), true);
//        $edit    = admin_url( 'post.php?post=' . $item_json['agency_phone'] . '&action=edit' );
//        $action = array(
//            "edit" => "sprintf( '<a href=\"%s\">Edit</a>', $edit )",
//            "delete" => ""
//        );
//        return sprintf('%1$s %2$s', $item_json['agency_phone'], $this->row_actions($action));
//    }

//}
//
//function listTableLayout()
//{
//    $listTable = new AgencyListTableClass();
////    Gọi item từ class
//    $listTable->prepare_items();
//    echo "<form method='post' name='formSearch' action='" . $_SERVER['PHP_SELF'] . "?page=dai-ly-ban-hang'>";
//    $listTable->search_box('Tìm đại lý', 'searh_agency');
//    echo "</form>";
//    $listTable->display();
//
//
//}
//
//listTableLayout();

require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
$model = new AgencyModel();
$data = $model->getAllAgencySort('create_at', 'desc');

?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 6px
    }

    .btn-action a {
        padding: 2px 4px;
    }

    .btn-action {
        text-align: center;
    }
</style>
<h3>Quản lý đại lý</h3>

<div class="agency">
    <table border="1">
        <thead>
        <th>Tên đại lý</th>
        <th>Nhân viên phụ trách</th>
        <th>Địa chỉ</th>
        <th>Số điện thoại</th>
        <th>Ngày tạo</th>
        <th>Thao tác</th>
        </thead>
        <tbody>
        <?php foreach ($data as $set) { ?>
            <tr>
                <td><a href="?page=dai-ly-ban-hang&action=select-agency&id=<?php echo $set->agency_id ?>"><?php echo $set->agency_name ?></a></td>
                <td><?php echo $set->display_name ?></td>
                <td><?php echo $set->agency_address ?></td>
                <td><?php echo $set->agency_phone ?></td>
                <td><?php echo $set->create_at ?></td>
                <td class="btn-action"><a
                            href="?page=dai-ly-ban-hang&action=edit-agency&id=<?php echo $set->agency_id ?>">Sửa</a> <a
                            href="?page=dai-ly-ban-hang&action=delete-agency&id=<?php echo $set->agency_id ?>">Xóa</a>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>
