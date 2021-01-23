<?php
global $wpdb;
@session_start();
$employee = $wpdb->prefix."employee";
$timesheet = $wpdb->prefix."timesheets";
if(isset($_GET['dlt_id']) && $_GET['dlt_id']!=""){
    $get = $wpdb->get_row("select * from $timesheet where id='".$_GET['dlt_id']."'",ARRAY_A);
    if(!empty($get)){
        $wpdb->query("delete from $timesheet where id='".$_GET['dlt_id']."'");
        $_SESSION['success'] = "Sheet Deleted Successfully.";
    }
}
?>
<style>
.outer{
    width: 96%;
    border-radius: 2px;
    background-color: #fff;
    float: left;
    min-height: 650px;
    height: auto;
    
    position: relative;
    margin-top: 20px;
    padding: 2em;
    border: 1px solid #ccd0d4;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
    box-sizing: border-box;
}
table#example tr td {
    text-align: center;
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
    <h1>Employee TimeSheets</h1>
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
                                echo "<p style='color:green;'>".$sheets_data['status']."</p>";
                            }else if($sheets_data['status'] != 'Pending'){
                                echo "<p style='color:red;'>".$sheets_data['status']."</p>";
                            }
                        ?></td>
                        <td> 
                        <a href="admin.php?page=et_add_sheet&sheet_id=<?php echo $sheets_data['id'] ?>">Edit</a> |
                        <a href="admin.php?page=et_timesheet&dlt_id=<?php echo $sheets_data['id'] ?>">Delete</a></td>
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