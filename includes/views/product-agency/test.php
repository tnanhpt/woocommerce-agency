<?php
require_once(ABSPATH . 'wp-content/plugins/woocommerce-agency/includes/model/agency.model.php');
$model = new AgencyModel();
$data = $model->getAllAgencyArr();
$agency = array();
foreach($data as $value){

        $agency[$value[0]]= $value[1];
    print_r($agency);
//    $agency= array_merge($agency, $result);
}

?>
<pre>
    <?php print_r($agency) ?>
</pre>
