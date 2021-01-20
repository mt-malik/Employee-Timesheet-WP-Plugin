<?php
@session_start();
global $wpdb;
$db = $wpdb->prefix."hunger";

if(isset($_REQUEST['cmd']) && $_REQUEST['cmd'] != ''){
 if($_REQUEST['cmd']=="add_menu"){
    //if(!isset($_REQUEST['id'])){
        $insert = "insert into $db (title,meal_type,type,price,description,image) values(
        '".$_REQUEST['title']."','".$_REQUEST['meal_type']."','".$_REQUEST['type']."','0','".$_REQUEST['description']."','".$_REQUEST['image']."')";
        
        if($wpdb->query($insert)){
            $_SESSION['suc'] = "Menu Item Saved Successfully.";
        }else{
             $_SESSION['eror'] = "An error occurred, Please try again. ";
        }
    /*}else{
        $update = "update $db set title='".$_REQUEST['title']."', type='".$_REQUEST['type']."', price='".$_REQUEST['price']."',
        description='".$_REQUEST['description']."', image='".$_REQUEST['image']."', video_length='".$_REQUEST['video_length']."' where id='".$_REQUEST['id']."'";
    }*/
  }  
  
  if($_REQUEST['cmd']=="update_menu"){
    $update = "update $db set title='".$_REQUEST['title']."', meal_type='".$_REQUEST['meal_type']."', type='".$_REQUEST['type']."', price='0',
        description='".$_REQUEST['description']."', image='".$_REQUEST['image']."' where id='".$_REQUEST['id']."'";
        if($wpdb->query($update)){
            $_SESSION['suc'] = "Menu Item Updated Successfully.";
        }else{
             $_SESSION['eror'] = "An error occurred, Please try again. ";
        }
            
  }
}
$id = "";
$title ="";
$type ="";
$meal_type = "";
$price ="";
$description ="";
$image = "";

if(isset($_GET['menu_id']) && $_GET['menu_id']!=""){
if($_GET['menu_id']!=""){
    $get = $wpdb->get_row("select * from $db where id='".$_GET['menu_id']."'",ARRAY_A);
    if(!empty($get)){
        $id =$get['id'];
        $title =$get['title'];
        $type =$get['type'];
        $meal_type =$get['meal_type'];
        $price =$get['price'];
        $description =$get['description'];
        $image =$get['image'];
    }
}
}


  //if(isset($_REQUEST['cmd']) && $_REQUEST['cmd']=="add_menu"){
 
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
<h1>List Page</h1>
<div class="outer">
<h3>Add/Edit</h3>
<form method="post" action="">
<?php
if($id!=""){
?>
    <input type="hidden" name="cmd" value="update_menu" />
<?php
}else{
    ?>
    <input type="hidden" name="cmd" value="add_menu" />
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
        <td><b>Title:</b></td>
        <td><input type="text" value="<?php echo $title;  ?>" name="title" class="inp_field" placeholder="Title" /></td>
    </tr>
    <tr>
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
    </tr>
    <tr>
        <td><b>What type of meals:</b></td>
        <td>    
            
            <select name="meal_type">
                <option value="">Select Type</option>
                <?php
                $array = array(
                    1=>"Healty",
                    2=>"Medium",
                    3=>"Lose Weight");
                foreach($array as $k=>$v){
                    if($k==$meal_type){
                        echo "<option selected='selected' value='$k'>$v</option>";
                    }else{
                        echo "<option value='$k'>$v</option>";
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <!--<tr>
        <td><b>Price:</b></td>
        <td><input type="text" name="price" value="<?php echo $price ?>" class="inp_field" placeholder="Price" /></td>
    </tr>-->
     <tr>
        <td><b>Description:</b></td>
        <td><input type="text" name="description" value="<?php echo $description ?>" placeholder="Description" class="inp_field" /></td>
    </tr>
     <tr>
            <td><b>Image</b></td>
            <td>
                <input type="button" class="button" onclick="wpimg_wc()" value="Select Image" />
                <br />
                <?php
                if(isset($image) && $image!=""){
                    $dsp = "";
                }else{
                    $dsp = "display: none;";
                }
                ?>
                <img src="<?php echo $image; ?>" style=" width: 160px; <?php echo $dsp; ?>" id="img" />
                <input type="hidden" value="<?php echo $image; ?>" name="image" id="url_link" />
            </td>
        </tr>
    
    <tr>
        <td colspan="2">
            <input type="submit" value="Save" class="button-primary" style="float: right;" />
        </td>
    </tr>
</table>
</form>
</div>
<script>
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