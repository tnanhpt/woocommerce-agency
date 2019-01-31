<?php
/**
 * Created by PhpStorm.
 * User: tnanh_000
 * Date: 12/5/2018
 * Time: 12:42 AM
 */
global $wpdb;
$id = $_GET['id'];
$wpdb->delete( $wpdb->base_prefix.'woocommerce_agency', array('agency_id' => $id));
header("Location:?page=dai-ly-ban-hang");
?>