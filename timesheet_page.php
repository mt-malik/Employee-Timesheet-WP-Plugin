<?php
global $wpdb;
@session_start();
$employee = $wpdb->prefix."employee";
$timesheet = $wpdb->prefix."timesheets";
if(isset($_GET['comment_id']) && $_GET['comment_id']!=""){
    $comment = "update $timesheet set status='".$_REQUEST['comment']."' where id='".$_REQUEST['comment_id']."' ";
    if($wpdb->query($comment)){
        $_SESSION['success'] = "Comment is Sent.";
        echo "<script type='text/javascript'>window.location.href='". $_REQUEST['re_url']."'</script>";  
        exit();
    }
}
if(isset($_REQUEST['comment_id']) && $_REQUEST['comment_id']!=""){
    $accept = "update $timesheet set status='Accepted' where id='".$_REQUEST['accept_id']."'";
    if($wpdb->query($accept)){
        $_SESSION['success'] = "Accepted.";
    }
}
if($wpdb->query($insert)){
    $_SESSION['success'] = "TimeSheet Saved Successfully.";
}else{
     $_SESSION['error'] = "An error occurred, Please try again. ";
}
?>
<style>
.outer{
    width: 100%;
    border-radius: 2px;
    background-color: #fff;
}
@media only screen and (max-width: 600px) {
    .outer{
        overflow: scroll;
    }
}
div#example_length {
    margin-bottom: 30px;
}
.page-header {
    padding-bottom: 9px;
    margin: 0px 0 20px;
    /* border-bottom: 1px solid #eee; */
    text-align: center;
}
.dataTables_info, .dataTables_paginate {
    margin-top: 20px;
}
table#example tr td {
    text-align: center;
}
table#example p{
    margin: 0;
}
.sh_btn a{
    color: #fff;
}
.com_btn{
    margin-left: -4px;
    padding: 10px;
}
.acc_btn{
    margin-right: -4px;
    padding: 10px;
}
.comment_sec .input-group-btn {
    position: relative;
    font-size: 0;
    white-space: nowrap;
}
.comment_sec .input-group {
    position: relative;
    display: table;
    border-collapse: separate;
}
.comment_sec input.form-control {
    height: 35px;
}
thead tr th:last-child {
    width: 310px;
}
.comment_form{
    width: auto;
    display: contents;
}
</style>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" />
<link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "pageLength": 25
    });
} );
</script>

<div class="outer">
    <div class="page-header"><h1>Timesheet</h1></div>
    <div style="width: 100%; max-width: 1080px; float: left;">
    <?php
     if(isset($_SESSION['success'])){
                ?>
                    <div class="updated settings-error notice is-dismissible">
                        <p><?php echo $_SESSION['success']; ?></p>
                    </div>
                <?php
                unset($_SESSION['success']);
            }
            ?>
    </div>
    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee Id</th>
                <th>Date</th>
                <th>Day</th>
                <th>Worked Hours</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if($_GET['page'] == 'et_sheet_pending'){
                $sheets_get = $wpdb->get_results("select * from $timesheet where status='Pending' order by status desc",ARRAY_A);
            }else if($_GET['page'] == 'et_sheet_rejected'){
                $sheets_get = $wpdb->get_results("select * from $timesheet where status<>'Pending' order by status desc",ARRAY_A);
            }else{
                $sheets_get = $wpdb->get_results("select * from $timesheet order by id desc",ARRAY_A);
            }
            foreach($sheets_get as $k=>$sheets_data){
                ?>
                    <tr id="r_<?php echo $sheets_data['id']; ?>">
                        <td><?php echo $sheets_data['id']; ?></td>
                        <td><?php 
                            $emp_get = $wpdb->get_results("select * from $employee where id='".$sheets_data['employee_id']."'",ARRAY_A);
                            foreach($emp_get as $k=>$emp_data){
                                $emp_jdata = json_decode($emp_data['user_data'],true);
                                echo $emp_jdata['user_login'];
                            } 
                            ?>
                        </td>
                        <td><?php echo $sheets_data['date']; ?></td>
                        <td><?php echo $sheets_data['day']; ?></td>
                        <td><?php echo $sheets_data['worked_hours']; ?></td>
                        <td><?php 
                            if($sheets_data['status'] == 'Pending'){
                                echo "<p style='color:red;'>".$sheets_data['status']."</p>";
                            }else if($sheets_data['status'] == 'Accepted'){
                                echo "<p style='color:green;'>".$sheets_data['status']."</p>";
                            }else{
                                echo $sheets_data['status'];
                            }
                        ?></td>
                        <td> 
                            <div class="input-group comment_sec">
                                <button type="button" class="sh_btn acc_btn"><a href="?accept_id=<?php echo $sheets_data['id'] ?>">Accept</a></button>
                                <form class="comment_form" method="post" action="">
                                    <input type="text" class="form-control" name="comment" placeholder="Comment here">
                                    <input type="hidden" name="re_url" value="<?php echo ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $uri_parts[0]; ?>">
                                    <input type="hidden" name="comment_id" value="<?php echo $sheets_data['id'] ?>"/>
                                    <span class="input-group-btn">
                                        <!-- <button type="submit" class="sh_btn com_btn"><a href="?comment_id=<?php echo $sheets_data['id'] ?>">Comment</a></button> -->
                                        <input type="submit" class="sh_btn com_btn" value="Comment"/>
                                    </span>
                                </form>
                            </div>   
                        </td>
                    </tr>
                <?php
            } 
            ?>
        </tbody>
        <tfoot>
            <th>ID</th>
            <th>Employee Id</th>
            <th>Date</th>
            <th>Day</th>
            <th>Worked Hours</th>
            <th>Status</th>
            <th>Action</th>
        </tfoot>
    </table>
</div>