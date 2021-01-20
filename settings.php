<?php
global $wpdb;
@session_start();
// $menu = $wpdb->prefix."hunger";
// if(isset($_GET['dlt_id']) && $_GET['dlt_id']!=""){
//     $get = $wpdb->get_row("select * from $menu where id='".$_GET['dlt_id']."'",ARRAY_A);
//     if(!empty($get)){
//         $wpdb->query("delete from $menu where id='".$_GET['dlt_id']."'");
//         $_SESSION['suc'] = "Menu Item Deleted Successfully.";
//     }
// }

?>
<style>
.outer{
    width: 96%;
    border-radius: 2px;
    /* background-color: #fff; */
    float: left;
    min-height: 650px;
    height: auto;
    padding: 2px;
}
.table tr{
    color: #212529;
    background-color: #212529;
    border-color: #32383e;
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #fff;
}
.table tr:first-child {
    background-color: #212529;
    color: #fff;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    text-align: left;
}
</style>
<h1>Settings</h1>
<div class="outer">
    
    <table class="table" style="width:50%">
        <tr>
            <th>Pages Detail</th>
            <td>Pages Shortcodes</td>
        </tr>
        <tr>
            <th>Employee Profile Page</th>
            <td>[employee_profile]</td>
        </tr>
        <tr>
            <th>Employee TimeSheet Page</th>
            <td>[employee_timesheet]</td>
        </tr>
    </table>
</div>