<?php
session_start();
//$dir = plugin_dir_url(__FILE__);
?>
<script src="http://code.jquery.com/jquery-1.11.2.min.js" type="text/javascript"></script>
<?php
global $wpdb;
$employee = $wpdb->prefix."employee";
$current_user = wp_get_current_user();

if(isset($_POST['cmd'])){
    if($_POST['cmd'] == 'create_user'){
        //registration_validation($_POST['username'], $_POST['useremail']);
        global $reg_errors;
        $reg_errors = new WP_Error;
        $username=$_POST['username'];
        $useremail=$_POST['email'];
        $password=$_POST['password'];
        if(empty( $username ) || empty( $useremail ) || empty($password))
        {
            $reg_errors->add('field', 'Required form field is missing');
        }    
        if ( 6 > strlen( $username ) )
        {
            $reg_errors->add('username_length', 'Username too short. At least 6 characters is required' );
        }
        if ( username_exists( $username ) )
        {
            $reg_errors->add('user_name', 'The username you entered already exists!');
        }
        if ( ! validate_username( $username ) )
        {
            $reg_errors->add( 'username_invalid', 'The username you entered is not valid!' );
        }
        if ( !is_email( $useremail ) )
        {
            $reg_errors->add( 'email_invalid', 'Email id is not valid!' );
        }
        if ( email_exists( $useremail ) )
        {
            $reg_errors->add( 'email', 'Email Already exist!' );
        }
        if ( 5 > strlen( $password ) ) {
            $reg_errors->add( 'password', 'Password length must be greater than 5!' );
        }
        if (is_wp_error( $reg_errors ))
        { 
            foreach ( $reg_errors->get_error_messages() as $error )
            {
                $signUpError='<p style="color:#FF0000; text-aling:left;"><strong>ERROR</strong>: '.$error . '<br /></p>';
            } 
        }
        if ( 1 > count( $reg_errors->get_error_messages() ) ){
            // sanitize user form input
            global $username, $useremail;
            $username   =   sanitize_user( $_POST['username'] );
            $useremail  =   sanitize_email( $_POST['email'] );
            $password   =   esc_attr( $_POST['password'] );
            ///Create User
            $user_id = wp_create_user( $username, $password, $useremail );
            $user = get_user_by( 'id', $user_id );
            $user->remove_role( 'subscriber' );
            $user->add_role( 'custom_role' );

            $cu_user_id = $user->ID;
            $user_data = json_encode($user->data);
            $insert = "insert into $employee (user_id,user_data,job_title,address,image) values(
                '$cu_user_id','$user_data','".$_REQUEST['job_title']."','".$_REQUEST['address']."','".$_REQUEST['image']."')";   
                // echo"<pre>";
                //     print_r($user_id);
                //     echo "<br/>";
                //     print_r($user_data);
                //     echo "<br/>";
                //     print_r($insert);
                // echo "</pre>";
                // die();
                $wpdb->query($insert);


            //$user = get_userdatabylogin( $username );
            // $user_id = $user->ID;
            // wp_set_current_user( $user_id, $user_login );
            // wp_set_auth_cookie( $user_id );
            // do_action( 'wp_login', $user_login );
            $signUpError='<p style="color:green; text-aling:left;"><strong>SUCCESS</strong>: Account Created Successfully.<br /></p>';
            // echo"<pre>";
            //         print_r($user);
            // echo "</pre>";
        }
}
if($_POST['cmd'] == 'login_user'){
    //We shall SQL escape all inputs  
    $username =$_REQUEST['username'];  
    $password =$_REQUEST['password'];  
    $remember =$_REQUEST['rememberme'];  
    //if($remember) $remember = "true";  
    //else $remember = "false";  
    $login_data = array();  
    $login_data['user_login'] = $username;  
    $login_data['user_password'] = $password;  
    $user_verify = wp_signon( $login_data, false );  
    if ( is_wp_error($user_verify) )   
    {  
        echo "Invalid login details";  
       // Note, I have created a page called "Error" that is a child of the login page to handle errors. This can be anything, but it seemed a good way to me to handle errors.  
     } else
    {    
       echo "<script type='text/javascript'>window.location.href='". ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']."'</script>";  
       exit();  
     }  
}
        // $username = str_replace(" ","",$_POST['username']);
        // $email = $_POST['email'];
        // $password = $_POST['password'];
        // if(username_exists($username) == null && email_exists($email) == false) {
        //     $user_id = @wp_create_user( $username, $password, $email );
        //     $user = @get_user_by( 'id', $user_id );
        //     $user->remove_role( 'subscriber' );
        //     $user->add_role( 'employee' );
        //     $_SESSION['success'] = "Account Created Successfully.";
        //     //wp_clear_auth_cookie();
        //     // wp_set_current_user ( $user_id );
        //     //wp_set_auth_cookie  ( $user_id );
        // echo"<pre>";
        //      print_r($user);
        // echo "</pre>";
        // //login
        // }else{
        //     $_SESSION['success'] = "Account Already available with this username/email.";
        // }
    // }
}
?>
<style>
.display_no {
    display: none;
}
.form-group input{
    width: 100%;
}
#loginform p {
    display: inline-grid;
    width: 100%;
}
</style>
<div class="row justify-content-center">
    <div class="wp-block-columns">
    <div class="wp-block-column" style="flex-basis:25%"></div>
        <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
    <?php
global $wpdb, $user_ID;  
if (!$user_ID) { 
    ?>
    <div class="col-12 register display_no">
        <form method="post" action="">
            <input type="hidden" name="cmd" value="create_user" />
            <h3>Create an account</h3>
            <div class="form-group col-md-12">
                <label for="inlineFormInputGroupUsername2">UserName</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="username"
                        placeholder="John Doesby">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inputEmail4">Email</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                    </div>
                    <input type="email" class="form-control" id="inputEmail4" name="email"
                        placeholder="John2012@ntl.com">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inputPassword4">Password</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                    </div>
                    <input type="password" class="form-control" id="inputPassword4" name="password"
                        placeholder="******">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inlineFormInputGroupjobtitle">Job Title</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroupjobtitle" name="job_title"
                        placeholder="e.g Devloper">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inlineFormInputGroupAddress">Address</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroupAddress" name="address"
                        placeholder="">
                </div>
            </div>
            <br/>
            <input type="submit" class="col-12 button button-primary" value="Create Account">
        </form>
    </div>
    <?php if(isset($signUpError)){echo '<div>'.$signUpError.'</div>';}?>
    <!---->
    <div class="col-12 login ">
        <h3>Login</h3>
        <!-- <form method="post" action="">
        <input type="hidden" name="cmd" value="login_user" />
            <div class="form-group col-md-12">
                <label for="inlineFormInputGroupUsername2">UserName</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="username"
                        placeholder="John Doesby">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inputPassword4">Password</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                    </div>
                    <input type="password" class="form-control" id="inputPassword4" name="password"
                        placeholder="******">
                </div>
            </div>
            <input type="submit" class="col-12 button button-primary" value="Login">
        </form> -->
        <?php  
            $defaults = array(
                'echo'           => true,
                // Default 'redirect' value takes the user back to the request URI.
                'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                'form_id'        => 'loginform',
                'label_username' => __( 'Username or Email Address' ),
                'label_password' => __( 'Password' ),
                'label_remember' => __( 'Remember Me' ),
                'label_log_in'   => __( 'Log In' ),
                'id_username'    => 'user_login',
                'id_password'    => 'user_pass',
                'id_remember'    => 'rememberme',
                'id_submit'      => 'wp-submit',
                'remember'       => true,
                'value_username' => '',
                // Set 'value_remember' to true to default the "Remember me" checkbox to checked.
                'value_remember' => false,
            );
            wp_login_form($defaults); 
        ?>
    </div>
    <div class="register form-check col-md-12 display_no">
        <label class="form-check-label login_form">Already have an account?
            <a href="">Click here to sign in</a>
        </label>
    </div>
    <div class="login form-check col-md-12">
        <label class="form-check-label register_form">Not have an account?
            <a href="">Click here to Create one</a>
        </label>
    </div>
    <?php
}else{
    //////
    if($_REQUEST['cmd']=="update_profile"){
        $update = "update $employee set address='".$_REQUEST['address']."', job_title='".$_REQUEST['job_title']."'
         where id='".$_REQUEST['emp_id']."'";
            if($wpdb->query($update)){
                $_SESSION['success'] = "Profile Updated Successfully.";
            }else{
                 $_SESSION['error'] = "An error occurred, Please try again. ";
            }
            echo "<script type='text/javascript'>window.location.href='". $_REQUEST['re_url']."'</script>";  
            exit();
      }
    $id = "";
    $name = "";
    $email = "";
    $address = "";
    $job_title = "";
    $image = "";
    
    // if(isset($_GET['menu_id']) && $_GET['menu_id']!=""){
    // if($_GET['menu_id']!=""){
        $current_user_id = $current_user->ID;
        $get = $wpdb->get_row("select * from $employee where user_id='".$current_user_id."'",ARRAY_A);
        if(!empty($get)){
            $id =$get['id'];
            $e_data = json_decode($get['user_data'],true); 
            $name = $e_data['user_login'];
            $email = $e_data['user_email'];
            $address =$get['address'];
            $job_title =$get['job_title'];
            $image =$get['image'];
        }
    // }
    // }
    $disabled = 'disabled';
    if(isset($_REQUEST['edit_id']) && $_REQUEST['edit_id']!== ''){
        $disabled = ' ';
        $edit_id = $_REQUEST['edit_id'];
    }
    ?>
    <div style="width: 100%; max-width: 1080px; float: left;">
    <?php
     if(isset($_SESSION['success'])){
        ?>
            <div class="settings-error notice is-dismissible">
                <p><p style="color:green; text-aling:left;"><strong>SUCCESS</strong>: <?php echo $_SESSION['success']; ?><br /></p></p>
            </div>
        <?php
        unset($_SESSION['success']);
    }
    ?>
    </div>
    <form method="post" action="">
    <input type="hidden" name="cmd" value="update_profile">
    <input type="hidden" name="emp_id" value="<?php echo $edit_id; ?>">
    <?php
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    ?>
    <input type="hidden" name="re_url" value="<?php echo ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $uri_parts[0]; ?>">
        <h3>Profile</h3>
        <div class="form-group col-md-12">
            <label for="inlineFormInputGroupUsername2">UserName</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" class="form-control" id="inlineFormInputGroupUsername2" value="<?php echo $name;?>" name="username"
                    placeholder="John Doesby" disabled>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="inputEmail4">Email</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                </div>
                <input type="email" class="form-control" id="inputEmail4" value="<?php echo $email;?>"  name="email"
                    placeholder="John2012@ntl.com" disabled>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="inlineFormInputGroupjobtitle">Job Title</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" class="form-control" id="inlineFormInputGroupjobtitle" value="<?php echo $job_title;?>" name="job_title"
                    placeholder="e.g Devloper" <?php echo $disabled; ?>>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="inlineFormInputGroupAddress">Address</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                </div>
                <input type="text" class="form-control" id="inlineFormInputGroupAddress" value="<?php echo $address;?>" name="address"
                    <?php echo $disabled; ?>>
            </div>
        </div>
        <br/>
        <?php
        if(isset($_REQUEST['edit_id']) && $_REQUEST['edit_id'] !== ''){
            ?>
            <input type="submit" class="button button-primary" value="Update">
            <?php
        }else{
        ?>
        <a href="?edit_id=<?php echo $id;?>" class="button button-primary">Edit</a>
        <?php
        }
        ?>
        
    </form>
        <br/>
<?php
}
?>   
    
</div>
        <div class="wp-block-column" style="flex-basis:25%"></div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        //jQuery('.count').prop('<?php echo $disabled; ?>', true);
        $(".login_form a").click(function () {
            //Do stuff when clicked
            jQuery('.register').addClass('display_no');
            jQuery('.login').removeClass('display_no');
            return false;
        });
        $(".register_form a").click(function () {
            //Do stuff when clicked
            jQuery('.login').addClass('display_no');
            jQuery('.register').removeClass('display_no');
            return false;
        });
    });
</script>