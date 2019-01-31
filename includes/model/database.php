<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE IF NOT EXISTS`{$wpdb->base_prefix}woocommerce_agency` (
      agency_id bigint(20) unsigned NOT NULL auto_increment,
      agency_name varchar(191) NOT NULL,
      agency_user varchar(191) NOT NULL,
      agency_address varchar(191) NULL,
      agency_phone varchar(20) NULL,
      create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      update_at TIMESTAMP DEFAULT now() ON UPDATE now(),
      PRIMARY KEY  (agency_id)
    ) $charset_collate;";
if (!function_exists('dbDelta')) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}
dbDelta($sql);
$charset_collate = $wpdb->get_charset_collate();
$product_sql = "CREATE TABLE IF NOT EXISTS`{$wpdb->base_prefix}agency_product` (
      id_amount bigint(20) unsigned NOT NULL auto_increment,
      agency_id bigint(20) NOT NULL,
      post_id bigint(20) NOT NULL,
      amount int(10) NULL,
      add_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      update_product_at TIMESTAMP DEFAULT now() ON UPDATE now(),
      PRIMARY KEY  (id_amount)
    ) $charset_collate;";
if (!function_exists('dbDelta')) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}
dbDelta($product_sql);
?>