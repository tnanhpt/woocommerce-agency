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
<h3>Danh sách tất cả các đại lý</h3>
<a href="?page=add-agency" class="btn-action">Thêm đại lý</a>
<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');

class AgencyListTableClass extends WP_List_Table
{
    public function data($orderBy = "", $order = "", $searchTerm = "")
    {
        $model = new AgencyModel();
        if (!empty($searchTerm)) {
            return $model->searchAgency($searchTerm);
        } else {
            switch ($orderBy) {
                case 'agency_name':
                    {
                        if ($order === "desc") {
                            return $model->getAllAgencySort('agency_name', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getAllAgencySort('agency_name', 'asc');
                        }
                        break;
                    }
                case 'agency_address':
                    {
                        if ($order === "desc") {
                            return $model->getAllAgencySort('agency_address', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getAllAgencySort('agency_address', 'asc');
                        }
                        break;
                    }
                case 'display_name':
                    {
                        if ($order === "desc") {
                            return $model->getAllAgencySort('display_name', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getAllAgencySort('display_name', 'asc');
                        }
                        break;
                    }
                case 'create_at':
                    {
                        if ($order === "desc") {
                            return $model->getAllAgencySort('create_at', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getAllAgencySort('create_at', 'asc');
                        }
                        break;
                    }
                case 'update_at':
                    {
                        if ($order === "desc") {
                            return $model->getAllAgencySort('update_at', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getAllAgencySort('update_at', 'asc');
                        }
                        break;
                    }
                default:
                    {
                        return $data = $model->getAllAgency();


                    }

            }
        }

//        return json_decode($model->getAllAgency(), true);
    }

//  chuẩn bị dữ liệu
    public function prepare_items()
    {
        $orderBy = isset($_GET['orderby']) ? trim($_GET['orderby']) : "";
        $order = isset($_GET['order']) ? trim($_GET['order']) : "";
        $serchTerm = isset($_POST['s']) ? trim($_POST['s']) : "";
        $data = json_decode(json_encode($this->data($orderBy, $order, $serchTerm)), true);
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $toltal_items = count($data);
        $this->set_pagination_args(array(
            "total_items" => $toltal_items,
            "per_page" => $per_page,

        ));


        $this->items = array_slice($data, (($current_page - 1) * $per_page), $per_page);
        $columns = $this->get_columns();
        $hiddens = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();


        $this->_column_headers = array($columns, $hiddens, $sortable);
    }


    public function get_columns()
    {
        $columns = array(
            "agency_id" => "ID",
            "agency_name" => "Tên đại lý",
            "display_name" => "Chủ đại lý",
            "agency_address" => "Địa chỉ",
            "agency_phone" => "Số điện thoại",
            "create_at" => "Ngày thêm",
            "update_at" => "Ngày cập nhật"
        );
        return $columns;
    }

    public function column_default($item, $column_name)
    {
        $item_json = json_decode(json_encode($item), true);
        switch ($column_name) {
            case 'agency_id':
            case 'agency_name':
            case 'display_name':
            case 'agency_address':
            case 'agency_phone':
            case 'create_at':
            case 'update_at':
                return $item_json[$column_name];
            default:
                return 'Không có dữ liệu';
        }
    }

    public function get_hidden_columns()
    {
        return array('');
    }

    public function get_sortable_columns()
    {
        return array(
            "agency_name" => array("agency_name", false),
            'display_name' => array("display_name", false),
            "agency_address" => array("agency_address", false),
            "create_at" => array("create_at", false),
            "update_at" => array("update_at", false)
        );
    }

    public function column_agency_name($item)
    {
        $actions = array(
            "edit" => sprintf('<a href="?page=%s&action=%s&id=%s">Chỉnh sửa</a>',$_REQUEST['page'],'edit-agency',$item['agency_id']),
            "delete" => sprintf('<a href="?page=%s&action=%s&id=%s">Xóa</a>',$_REQUEST['page'],'delete-agency',$item['agency_id'])
        );
        return sprintf('<a href="?page=%s&action=%s&id=%s"  class="row-title">%s</a>%s',
            $_REQUEST['page'],
            'select-agency',
            $item['agency_id'],
            $item['agency_name'],
            $this->row_actions($actions)
            );
//        return sprintf('<a href="#" class="row-title">%1$s</a>%3$s',
//            /*$1%s*/ $item['agency_name'],
//            /*$2%s*/ $item['agency_id'],
//            /*$3%s*/ $this->row_actions($actions)
//        );
    }

}

function listTableLayout()
{
    $listTable = new AgencyListTableClass();
//    Gọi item từ class
    $listTable->prepare_items();
    echo "<form method='post' name='formSearch' action='" . $_SERVER['PHP_SELF'] . "?page=dai-ly-ban-hang'>";
    $listTable->search_box('Tìm đại lý', 'search_agency');
    echo "</form>";
    $listTable->display();


}

listTableLayout();
