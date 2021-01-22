<?php
@session_start();
global $wpdb;
$timesheet = $wpdb->prefix."timesheets";
$employee = $wpdb->prefix."employee";

if(isset($_REQUEST['cmd']) && $_REQUEST['cmd'] != ''){
 if($_REQUEST['cmd']=="add_sheet"){
    //if(!isset($_REQUEST['id'])){
        $insert = "insert into $timesheet (title,meal_type,type,price,description,image) values(
        '".$_REQUEST['title']."','".$_REQUEST['meal_type']."','".$_REQUEST['type']."','0','".$_REQUEST['description']."','".$_REQUEST['image']."')";
        
        if($wpdb->query($insert)){
            $_SESSION['suc'] = "sheet Item Saved Successfully.";
        }else{
             $_SESSION['eror'] = "An error occurred, Please try again. ";
        }
    /*}else{
        $update = "update $timesheet set title='".$_REQUEST['title']."', type='".$_REQUEST['type']."', price='".$_REQUEST['price']."',
        description='".$_REQUEST['description']."', image='".$_REQUEST['image']."', video_length='".$_REQUEST['video_length']."' where id='".$_REQUEST['id']."'";
    }*/
  }  
  
  if($_REQUEST['cmd']=="update_sheet"){
    $update = "update $timesheet set title='".$_REQUEST['title']."', meal_type='".$_REQUEST['meal_type']."', type='".$_REQUEST['type']."', price='0',
        description='".$_REQUEST['description']."', image='".$_REQUEST['image']."' where id='".$_REQUEST['id']."'";
        if($wpdb->query($update)){
            $_SESSION['suc'] = "sheet Item Updated Successfully.";
        }else{
             $_SESSION['eror'] = "An error occurred, Please try again. ";
        }
            
  }
}
$id = "";
$employee_id ="";
$date ="";
$day = "";
$worked_hours = "";
$status ="";

if(isset($_GET['sheet_id']) && $_GET['sheet_id']!=""){
if($_GET['sheet_id']!=""){
    $get = $wpdb->get_row("select * from $timesheet where id='".$_GET['sheet_id']."'",ARRAY_A);
    if(!empty($get)){
        $id =$get['id'];
        $employee_id =$get['employee_id'];
        $date =$get['date'];
        $day =$get['day'];
        $worked_hours = $get['worked_hours'];
        $status =$get['status'];
    }
}
}


  //if(isset($_REQUEST['cmd']) && $_REQUEST['cmd']=="add_sheet"){
 
?>
<style>
.outer{
    width: 96%;
    border-radius: 2px;
    backgnumber_format-color: #fff;
    float: left;
    min-height: 650px;
    height: auto;
    padding: 2px;
}
.inp_field{
    width: 100%; 
}
</style>
<h1>Add Sheet</h1>
<div class="outer">
<h3>Add/Edit</h3>
<form method="post" action="">
<?php
if($id!=""){
?>
    <input type="hidden" name="cmd" value="update_sheet" />
<?php
}else{
    ?>
    <input type="hidden" name="cmd" value="add_sheet" />
    <?php
}
?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<table style="width: 500px;">
    <tr>
        <td colspan="2">
             <?php
            if(isset($_SESSION['suc'])){
                ?>
                    <div class="updated settings-error notice is-dismissible">
                        <p><?php echo $_SESSION['suc']; ?></p>
                    </div>
                <?php
                unset($_SESSION['suc']);
            }
             if(isset($_SESSION['eror'])){
                ?>
                    <div class="update-message notice inline notice-warning notice-alt">
                        <p><?php echo $_SESSION['eror']; ?></p>
                    </div>
                <?php
                unset($_SESSION['eror']);
            }
        ?>
        </td>
    </tr>
    <tr>
        <td><b>Select Employee:</b></td>
        <td>
        <select>
            <?php
            $sheets_get = $wpdb->get_results("select * from $employee order by id desc",ARRAY_A);
            foreach($sheets_get as $k=>$sheets_data){
                $employee_data = json_decode($sheets_data['user_data'],true);
            ?>
            
            <option value="<?php echo $sheets_data['id']; ?>"><?php echo $employee_data['user_login']; ?></option>
            <?php
            }
            ?>
        </select>
    </tr>
    <!-- <tr>
        <td><b>Type:</b></td>
        <td>    
            
            <select name="type">
                <option value="">Select Type</option>
                <?php
                $array = array(
                    1=>"White Meats",
                    2=>"Red Meat",
                    3=>"Fish",
                    4=>"Vegan",
                    5=>"Low Calorie");
                foreach($array as $k=>$v){
                    if($k==$type){
                        echo "<option selected='selected' value='$k'>$v</option>";
                    }else{
                        echo "<option value='$k'>$v</option>";
                    }
                }
                ?>
            </select>
        </td>
    </tr> -->

    <tr>
        <td><b>Date:</b></td>
        <td><input type="date" id="date-input" name="date" value="<?php echo $date ?>" class="inp_field" placeholder="Date" />
        </td>
    </tr>
    <tr>
        <td><b>Day:</b></td>
        <td><input type="text" id="day_input" name="day" value="<?php echo $day ?>" class="inp_field" placeholder="Day" disabled/></td>
    </tr>
    <!-- <input type="radio" name="day" value="<?php echo date("l"); ?>">
            <input type="radio" name="day" value="<?php echo date("l"); ?>">
            <input type="radio" name="date" value="<?php echo date("d-m-Y"); ?>"><?php echo date("d-m-Y"); ?>
            <input type="radio" name="date" value="<?php echo date("l"); ?>"><?php echo date("l"); ?> -->
     <tr>
        <td><b>Worked Hours :</b></td>
        <td><input type="text" name="worked_hours" value="<?php echo $worked_hours  ?>" placeholder="Worked Hours" class="inp_field" /></td>
    </tr>
    <?php
    if($status){
    ?>
     <tr>
        <td><b>Status:</b></td>
        <td><input type="text" name="status" value="<?php echo $status ?>" placeholder="Status" class="inp_field" /></td>
    </tr>
    <?php
    } 
    ?>
    <tr>
        <td colspan="2">
            <input type="submit" value="Save" class="button-primary" style="float: right;" />
        </td>
    </tr>
</table>
</form>
</div>
<script>
jQuery("#date-input").on("change paste keyup", function() {
    var d =jQuery(this).val();
    var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var a = new Date(d);
    var day = weekday[a.getDay()];
    jQuery('#day_input').val(day);
    // alert(day); 
});
var wpimg_wc = function(title,onInsert,isMultiple){
  if(isMultiple == undefined)
   isMultiple = false;
  // Media Library params
  var frame = wp.media({
   title   : title,
   multiple  : isMultiple,
   library  : { type : 'image'},
   button   : { text : 'Insert' }
  });
  // Runs on select
  frame.on('select',function(){
   var objSettings = frame.state().get('selection').first().toJSON();
   var selection = frame.state().get('selection');
   var arrImages = [];
   if(isMultiple == true){ //return image object when multiple
    selection.map( function( attachment ) {
     var objImage = attachment.toJSON();
     var obj = {};
     obj.url = objImage.url;
     obj.id  = objImage.id;
     arrImages.push(obj);
    });
        wpimgpr_slides(arrImages,"multi");
   }else{
        wpimgpr_slides(objSettings.url,"single");
   }
  });
  // Open ML
  frame.open();
 }
 function wpimgpr_slides(img,types){
    if(types=="single"){
        jQuery('#img').attr("src",img);
        jQuery('#url_link').val(img);
        jQuery('#img').show();
        
    }else{ // multiple images upload
      //  alert("Multiple")
           
    }
 }
</script>