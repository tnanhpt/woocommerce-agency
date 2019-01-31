<?php
global $wpdb;
$id_agency = $_GET['id'];
$agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
$query = "Select agency_name from $agencyTable WHERE agency_id = $id_agency";
$agency_name = $wpdb->get_row($query);
?>
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
<div class="flex-custome">
    <h3><?php echo $agency_name->agency_name ?></h3>
    <a href="?page=dai-ly-ban-hang&action=add-product-agency&id-agency=<?php echo $id_agency ?>" class="btn-action">Thêm sản phẩm</a>
</div>
<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');

class AgencyListTableClass extends WP_List_Table
{

    public function data($idAgency = "", $orderBy = "", $order = "", $searchTerm = "")
    {
        $model = new AgencyModel();
        if (!empty($searchTerm)) {
            return $model->searchAgencyProduct($idAgency, $searchTerm);
        } else {
            switch ($orderBy) {
                case 'post_title':
                    {
                        if ($order === "desc") {
                            return $model->getProductAgencyByIdAgencySort($idAgency,'post_title', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getProductAgencyByIdAgencySort($idAgency,'post_title', 'asc');
                        }
                        break;
                    }
                case 'amount':
                    {
                        if ($order === "desc") {
                            return $model->getProductAgencyByIdAgencySort($idAgency,'amount', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getProductAgencyByIdAgencySort($idAgency,'amount', 'asc');
                        }
                        break;
                    }
                case 'add_at':
                    {
                        if ($order === "desc") {
                            return $model->getProductAgencyByIdAgencySort($idAgency,'add_at', 'desc');
                        }
                        if ($order === 'asc') {
                            return $model->getProductAgencyByIdAgencySort($idAgency,'add_at', 'asc');
                        }
                        break;
                    }
                default:
                    {
                        return $data = $model->getProductAgencyByIdAgency($idAgency);


                    }

            }
        }

//        return json_decode($model->getAllAgency(), true);
    }

//  chuẩn bị dữ liệu
    public function prepare_items()
    {
        $idAgency = isset($_GET['id']) ? trim($_GET['id']) : "";
        $orderBy = isset($_GET['orderby']) ? trim($_GET['orderby']) : "";
        $order = isset($_GET['order']) ? trim($_GET['order']) : "";
        $serchTerm = isset($_POST['s']) ? trim($_POST['s']) : "";
        $data = $this->data($idAgency,$orderBy, $order, $serchTerm);
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
            "post_title" => "Sàn phẩm",
            "amount" => "Số lượng",
            "add_at" => "Ngày thêm",
            "update_product_at" => "Ngày cập nhật"
        );
        return $columns;
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'post_title':
            case 'amount':
            case 'add_at':
            case "update_product_at":
                return $item[$column_name];
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
            "post_title" => array("post_title", false),
            'amount' => array("amount", false),
            "add_at" => array("add_at", false),
            "update_product_at" => array("update_product_at", false)
        );
    }

    public function column_post_title($item)
    {
        $idAgency = isset($_GET['id']) ? trim($_GET['id']) : "";
        $actions = array(
            "edit" => sprintf('<a href="?page=%s&action=%s&id-agency=%s&id-product=%s">Sửa số lượng</a>',
                $_REQUEST['page'],
                'edit-product-agency',
                $idAgency,
                $item['id_amount']
            ),
            "delete" => sprintf('<a href="?page=%s&action=%s&id-agency=%s&id-product=%s">Xóa</a>',
                $_REQUEST['page'],
                'delete-product-agency',
                $idAgency,
                $item['id_amount']
            )
        );
        return sprintf('<a href="post.php?post=%s&action=edit"  class="row-title">%s</a>%s',
            $item['ID'],
            $item['post_title'],
            $this->row_actions($actions)
        );
//        return sprintf('<a href="#" class="row-title">%1$s</a>%3$s',
//            /*$1%s*/ $item['agency_name'],
//            /*$2%s*/ $item['agency_id'],
//            /*$3%s*/ $this->row_actions($actions)
//        );
    }

}

function listTableLayout($id_agency)
{
    $listTable = new AgencyListTableClass();
//    Gọi item từ class
    $listTable->prepare_items();
    echo "<form method='post' name='formSearch' action='" . $_SERVER['PHP_SELF'] . "?page=dai-ly-ban-hang&action=select-agency&id=".$id_agency ."'>";
    $listTable->search_box('Tìm sản phẩm', 'search_product');
    echo "</form>";
    $listTable->display();


}

listTableLayout($id_agency);
