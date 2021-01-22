<?php
global $wpdb;
@session_start();
$employee = $wpdb->prefix."employee";
$timesheet = $wpdb->prefix."timesheets";
if(isset($_GET['dlt_id']) && $_GET['dlt_id']!=""){
    $get = $wpdb->get_row("select * from $timesheet where id='".$_GET['dlt_id']."'",ARRAY_A);
    if(!empty($get)){
        $wpdb->query("delete from $timesheet where id='".$_GET['dlt_id']."'");
        $_SESSION['suc'] = "Menu Item Deleted Successfully.";
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
     if(isset($_SESSION['suc'])){
                ?>
                    <div class="updated settings-error notice is-dismissible">
                        <p><?php echo $_SESSION['suc']; ?></p>
                    </div>
                <?php
                unset($_SESSION['suc']);
            }
            ?>
    </div>
    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee Id</th>
                <th>date</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <tr>
        <?php
                $sheets_get = $wpdb->get_results("select * from $timesheet order by id desc",ARRAY_A);
                foreach($sheets_get as $k=>$sheets_data){
                    ?>
                        <tr id="r_<?php echo $sheets_data['id']; ?>">
                            <td><?php echo $sheets_data['employee_id']; ?></td>
                            <td><?php echo $sheets_data['date']; ?></td>
                            <td><?php echo $sheets_data['mon']; ?></td>
                            <td><?php echo $sheets_data['tue']; ?></td>
                            <td><?php echo $sheets_data['wed']; ?></td>
                            <td><?php echo $sheets_data['thu']; ?></td>
                            <td><?php echo $sheets_data['fri']; ?></td>
                            <td><?php echo $sheets_data['sat']; ?></td>
                            <td><?php echo $sheets_data['status']; ?></td>
                            <td> 
                            <a href="admin.php?page=hn_view_order&order_id=<?php echo $sheets_data['id'] ?>">View</a> |
                            <a href="admin.php?page=hn_orders&dlt_id=<?php echo $sheets_data['id'] ?>">Delete</a></td>
                        </tr>
                    <?php
                } 
            ?>
        </tr>
        </tbody>
        <tfoot>
            <th>ID</th>
            <th>Employee Id</th>
            <th>date</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Status</th>
            <th>Action</th>
        </tfoot>
    </table>
</div>