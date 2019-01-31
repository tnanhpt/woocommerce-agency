<?php
/**
 * Created by PhpStorm.
 * User: tnanh_000
 * Date: 12/7/2018
 * Time: 9:41 PM
 */

class AgencyModel
{
    public $wpdb;
    public function __construct()
    {

    }

    public function queryOne($query)
    {
        global $wpdb;
        return $wpdb->get_row($query);
    }

    public function queryAll($query)
    {
        global $wpdb;
        return $wpdb->get_results($query);
    }
    public function queryAllArr($query) {
        global $wpdb;
        return $wpdb->get_results($query, ARRAY_A);
    }
    public function queryAllArrIndex($query) {
        global $wpdb;
        return $wpdb->get_results($query, ARRAY_N);
    }


    public function getAllAgency()
    {
        global $wpdb;
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $userTable = "{$wpdb->base_prefix}users";
        $query = "SELECT agency_name, agency_address, agency_phone, agency_user, agency_id, create_at,update_at, ID, display_name, user_email FROM $agencyTable,$userTable WHERE $agencyTable.agency_user =  $userTable.ID";
        return $this->queryAll($query);
    }
    public function getAllAgencyArr()
    {
        global $wpdb;
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $userTable = "{$wpdb->base_prefix}users";
        $query = "SELECT agency_name, agency_address, agency_phone, agency_user, agency_id, create_at,update_at, ID, display_name, user_email FROM $agencyTable,$userTable WHERE $agencyTable.agency_user =  $userTable.ID";
        return $this->queryAllArr($query);
    }

    public function getAgencyById($id)
    {
        global $wpdb;
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $userTable = "{$wpdb->base_prefix}users";
        $query = "SELECT agency_name, agency_address, agency_phone, agency_user, agency_id, create_at,update_at, ID, display_name, user_email FROM $agencyTable,$userTable WHERE $agencyTable.agency_user =  $userTable.ID AND $agencyTable.agency_id = $id";
        return $this->queryOne($query);
    }

    public function searchAgency($key)
    {
        global $wpdb;
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $userTable = "{$wpdb->base_prefix}users";
        $query = "SELECT agency_name, agency_address, agency_phone, agency_user, agency_id, create_at,update_at, ID, display_name, user_email FROM $agencyTable,$userTable WHERE $agencyTable.agency_user =  $userTable.ID AND ($agencyTable.agency_name LIKE '%$key%' OR $userTable.display_name LIKE '%$key%' OR $agencyTable.agency_address OR $agencyTable.agency_phone  LIKE '%$key%' OR agency_phone LIKE '%$key%')";
        return $this->queryAll($query);
    }

    public function getAllAgencySort($field, $typeSort)
    {
        global $wpdb;

        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $userTable = "{$wpdb->base_prefix}users";
        $query = "SELECT agency_name, agency_address, agency_phone, agency_user, agency_id, create_at,update_at, ID, display_name, user_email FROM $agencyTable,$userTable WHERE $agencyTable.agency_user =  $userTable.ID  ORDER BY $field $typeSort";
        return $this->queryAll($query);
    }
//    public function getProductPublic()
//    {
//        global $wpdb;
//        $query = "SELECT * FROM {$wpdb->base_prefix}posts WHERE post_type = 'product' AND post_status = 'publish'";
//        return $this->queryAll($query);
//    }
    public function getProductAgencyByIdAgency($idAgency)
    {
        global $wpdb;
        $postTable = "{$wpdb->base_prefix}posts";
        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $query = "Select * from $postTable, $agencyTable, $agencyProductTable WHERE $postTable.ID = $agencyProductTable.post_id AND $agencyTable.agency_id = $agencyProductTable.agency_id AND $agencyProductTable.agency_id = $idAgency";
        return $this->queryAllArr($query);
    }
    public function getProductAgencyByIdAgencySort($idAgency, $field, $typeSort)
    {
        global $wpdb;
        $postTable = "{$wpdb->base_prefix}posts";
        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $query = "Select * from $postTable, $agencyTable, $agencyProductTable WHERE $postTable.ID = $agencyProductTable.post_id AND $agencyTable.agency_id = $agencyProductTable.agency_id AND $agencyProductTable.agency_id = $idAgency ORDER BY $field $typeSort";
        return $this->queryAllArr($query);
    }
//    public function getAllProductAgency() {
//        global $wpdb;
//        $postTable = "{$wpdb->base_prefix}posts";
//        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
//        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
//        $query = "Select * from $postTable, $agencyTable, $agencyProductTable WHERE $postTable.ID = $agencyProductTable.post_id AND $agencyTable.agency_id = $agencyProductTable.agency_id AND $postTable.post_type = 'product' AND $postTable.post_status = 'publish'";
//        return $this->queryAll($query);
//    }

    public function getAllProduct()
    {
        global $wpdb;
        $postTable = "{$wpdb->base_prefix}posts";
        $query = "Select * from $postTable WHERE $postTable.post_type = 'product' AND $postTable.post_status = 'publish'";
        return $this->queryAll($query);
    }
    public function getAllProductNotExisted($id_agency)
    {
        global $wpdb;

        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $postTable = "{$wpdb->base_prefix}posts";
        $query = "Select * from $postTable WHERE $postTable.post_type = 'product' AND $postTable.post_status = 'publish'
        AND ID NOT IN (SELECT post_id FROM $agencyProductTable WHERE $agencyProductTable.agency_id = $id_agency)";
        return $this->queryAll($query);
    }
    public function getUserAgency()
    {
        $args = array(
            'role' => 'shop_manager'
        );
        return get_users($args);
    }

    public function getProductAgencyById($id) {
        global $wpdb;
        $postTable = "{$wpdb->base_prefix}posts";
        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $sql = "SELECT * from $agencyProductTable,$postTable  WHERE id_amount = $id AND $agencyProductTable.post_id = $postTable.ID";
        return $this->queryOne($sql);

    }

    public function getNameAgency() {
        global $wpdb;
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
        $sql = "SELECT agency_id, agency_name FROM $agencyTable";
       return $this->queryAllArrIndex($sql);
    }
    public function searchAgencyProduct($idAgency, $key)
    {
        global $wpdb;
        $postTable = "{$wpdb->base_prefix}posts";
        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $query = "Select * from $postTable, $agencyProductTable WHERE $postTable.ID = $agencyProductTable.post_id AND $agencyProductTable.agency_id = $idAgency AND ($postTable.post_title LIKE '%$key%' OR $agencyProductTable.amount LIKE '%$key%' OR $agencyProductTable.add_at LIKE '%$key%' OR $agencyProductTable.update_product_at LIKE '%$key%')";
        return $this->queryAllArr($query);
    }
    public function getAgencyNameById($id)
    {
        global $wpdb;
        $agencyTable = "{$wpdb->base_prefix}woocommerce_agency";
       $query = "SELECT agency_name FROM $agencyTable WHERE agency_id = $id";
        return $this->queryOne($query);
    }

    public function getAmountProductByIdProductAndAgencyId($product_id, $agency_id){
        global $wpdb;
        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $sql = "SELECT amount FROM $agencyProductTable  WHERE agency_id = $agency_id and post_id = $product_id";
        echo $sql;
        return $this->queryOne($sql);
    }

    public function subtract_product_amount($product_id, $agency_id, $amount_new) {
        global $wpdb;
        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $sql = "UPDATE $agencyProductTable SET amount= $amount_new  WHERE agency_id = $agency_id and post_id = $product_id";
        return $this->queryOne($sql);
    }
    public function checkExistProductAgency($product_id, $agency_id) {
        global $wpdb;
        $agencyProductTable = "{$wpdb->base_prefix}agency_product";
        $sql = "SELECT EXISTS  (SELECT 1 FROM $agencyProductTable WHERE post_id = $product_id And agency_id = $agency_id) as isExisted";
        return $this->queryOne($sql);
    }
}