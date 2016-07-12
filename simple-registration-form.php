<?php
/**
 * Plugin Name: Simple Registration Form
 * Plugin URI: 
 * Description: Using Registration and Login Page 
 
*/

//define('WP_DEBUG',true);
define('SRF_REGISTRATION_INCLUDE_URL', plugin_dir_url(__FILE__).'includes/');
ob_start();
require_once('config.php');
 require_once( ABSPATH . 'wp-admin/includes/file.php' );
//add front end css and js
function srf_slider_trigger(){
	wp_enqueue_style('srf_caro_css_and_js', SRF_REGISTRATION_INCLUDE_URL."front-style.css"); 
    wp_register_script('srf_caro_css_and_js', SRF_REGISTRATION_INCLUDE_URL."font-script.js" );
	wp_enqueue_script('srf_caro_css_and_js');
}
add_action('wp_footer','srf_slider_trigger');

// function to registration Shortcode
function srf_registration_shortcode( $atts ) {
    global $wpdb, $user_ID; 
	$firstname='';
	$lastname='';
	$username='';
	$email='';
	
	//if looged in rediret to home page
	/*if ( is_user_logged_in() ) { 
	    wp_redirect( get_option('home') );// redirect to home page
		exit;
	}*/

	if(sanitize_text_field( $_POST['submit']) != ''){

		$firstname=sanitize_text_field( $_REQUEST['firstname'] );
		
		$lastname=sanitize_text_field( $_REQUEST['lastname']);
		
		$username = sanitize_text_field(  $_REQUEST['username'] );
		
		$email = sanitize_text_field(  $_REQUEST['email']  );
		
		$password = $wpdb->escape( sanitize_text_field( $_REQUEST['password']));
		
		
		$status = $wpdb->insert(registration,array('first_name'=>$_POST['firstname'],'last_name'=>$_POST['lastname'],'user_name'=>$_POST['username'],'email'=>$_POST['email'],'password'=>$_POST['password']));
		
		//$status = "insert into registration(first_name,last_name,user_name,email,password) values('$firstname','$lastname','$username','$email','$password')";
		
		//$wpdb->$status;
		
		
		$wpdb->show_errors();	

			//$query = "SELECT COUNT(*) FROM registration";
			//$wpdb->get_var($query);

		
		$succress ='';
		$error_msg='';
	   
		if (is_wp_error($status))  {
		     $error_msg = __('Username or Email already registered. Please try another one.',''); 
		} 
		else{
			$user_id=$status;
			//update_user_meta( $user_id,'first_name', $firstname);
			//update_user_meta( $user_id,'last_name', $lastname);
			
			$succress= __('Your are register successfully for this site.',''.print_r($user_id)); 			
		}  
	}
?>
	<div class="alar-registration-form">
		<div class="alar-registration-heading">
		<?php _e("Registration Form",'');?>
		</div>
		<?php if($error_msg!='') { ?><div class="error"><?php echo $error_msg; ?></div><?php }  ?>
		<?php if($succress!='') { ?><div class="success"><?php echo $succress; ?></div><?php }  ?>
		
		<form  name="form" id="registration"  method="post">
			<div class="ftxt">
			 <label><?php _e("First Name :",'');?></label> 
			 <input id="firstname" name="firstname" type="text" class="input" required value=<?php echo $firstname; ?> > 
			</div>
			<div class="ftxt">
			 <label><?php _e("Last name :",'');?></label>  
			 <input id="lastname" name="lastname" type="text" class="input" required value=<?php echo $lastname; ?> >
			</div>
			<div class="ftxt">
			 <label><?php _e("Username :",'');?></label> 
			 <input id="username" name="username" type="text" class="input" required value=<?php echo $username; ?> >
			</div>
			<div class="ftxt">
			<label><?php _e("E-mail :",'');?> </label>
			 <input id="email" name="email" type="email" class="input" required value=<?php echo $email; ?> >
			</div>
			<div class="ftxt">
			<label><?php _e("Password :",'');?></label>
			 <input id="password1" name="password" type="password" required class="input" />
			</div>
			<div class="ftxt">
			<label><?php _e("Confirm Password : ",'');?></label>
			 <input id="password2" name="c_password" type="password" class="input" />
			</div>
			<div class="fbtn"><input type="submit" name='submit' class="button"  value="Register"/> </div>
		</form>
	</div>
<?php	
}


//............For Login User .....//


function login_shortcode( $atts ) {
  	 global $wpdb, $user_ID; 
	$username='';
	$password='';
	
	//if looged in rediret to home page
	/*if ( is_user_logged_in() ) { 
	    wp_redirect( get_option('home') );// redirect to home page
		exit;
	}*/

	if(sanitize_text_field( $_POST['submit']) != ''){

		
		
		$username = sanitize_text_field( $_REQUEST['username'] );		
	
		$password = $wpdb->escape(sanitize_text_field( $_REQUEST['password']));
		
		
		//$status = $wpdb->insert(registration,array('first_name'=>$_POST['firstname'],'last_name'=>$_POST['lastname'],'user_name'=>$_POST['username'],'email'=>$_POST['email'],'password'=>$_POST['password']));
		
		$status_login = "select user_name,password from registration where user_name='$username' and password='$password'";
		
		//echo $status_login;
		
		//$wpdb->get_var($status_login);
		
		//$query = $wpdb->$status_login;
		
		$t_login = $wpdb->get_results($status_login);
		
		$n_rows = $wpdb->num_rows;
		
		print_r($n_rows);
		
		$wpdb->show_errors();	

			//$query = "SELECT COUNT(*) FROM registration";
					
		$succress ='';
		$error_msg='';
	   
		if ($n_rows>0)  {		     
			 
			$succress= __('Successfully Login','');
			
			/* get template dir */
			
			$template = str_replace( '%2F', '/', rawurlencode( get_template() ) );
			$theme_root_uri = get_theme_root_uri( $template );
			$template_dir_uri = "$theme_root_uri/$template";
			
			//print $template_dir_uri;
			/* End of get template */
			
			wp_redirect( $template_dir_uri.'/shoppingcart.php/' );// redirect to home page
			 
		} 
		else{
			//$user_id=$query;
			//update_user_meta( $user_id,'first_name', $firstname);
			//update_user_meta( $user_id,'last_name', $lastname);
			
			 $error_msg = __('Error On Username and password',''); 
			
		}  
	}
?>
	<div class="alar-registration-form">
		<div class="alar-registration-heading">
		<?php _e("Login Form",'');?>
		</div>
		<?php if($error_msg!='') { ?><div class="error"><?php echo $error_msg; ?></div><?php }  ?>
		<?php if($succress!='') { ?><div class="success"><?php echo $succress; ?></div><?php }  ?>
		
		<form  name="form" id="registration"  method="post">
			<div>
			<div class="ftxt">
			 <label><?php _e("Username :",'');?></label> 
			 <input id="username" name="username" type="text" class="input" required value=<?php echo $username; ?> >
			</div>			
			<div class="ftxt">
			<label><?php _e("Password :",'');?></label>
			 <input id="password1" name="password" type="password" required class="input" />
			</div>			
			<div class="fbtn"><input type="submit" name='submit' class="button"  value="Login"/> </div>
		</form>
	</div>
<?php	
}


/* For Shopping Cart */

function add_cart()
{  
  global $wpdb, $user_ID; 
	if(sanitize_text_field( $_POST['submit']) != ''){

		$productname=sanitize_text_field( $_REQUEST['p_name'] );
				
		$image = sanitize_text_field($_FILES['p_img']['name']);		
		
		
		  echo $files = $_FILES['p_img']['name'];
		  
		
		$status = $wpdb->insert(cart,array('p_name'=>$productname,'p_img'=>$image));

		$img = "insert into cart('p_name','p_img') values($productname,$image)";
		
		print ($img);
		
		$wpdb->show_errors();		
		
		$succress ='';
		$error_msg='';
	   
		if (is_wp_error($status))  {
		     $error_msg = __('Product Name Already Existsts.-->Please try another one.',''); 
		} 
		else{
			$user_id=$status;
			
			$succress= __('Your are successfully  add Product.',''.print_r($user_id)); 			
		}  
	}
	?>
<html>
	<?php if($error_msg!='') { ?><div class="error"><?php echo $error_msg; ?></div><?php }  ?>
	<?php if($succress!='') { ?><div class="success"><?php echo $succress; ?></div><?php }  ?>
	<form name="cart_form" id="cart_form" method="post">
		<label>Product Name</label>
			<input type="text" name="p_name" id="p_name">
		<label>Product Image</label>
			<input type="file" name="p_img" id="p_img">
			<input type="submit" name="submit" id="sub" />	
	</form>
</html>
	
<?php	
	
}
function show_cart()
{
		global $wpdb;
	
		$cart_qery = "select p_name,p_img from cart order by p_name asc";		
			
		$cart_data = $wpdb->get_results($cart_qery);
		
		//Print_r($cart_data[p_name][0]);		
	
		foreach($cart_data as $row)
		{
			echo $row->id."  ".$row->p_name."<br>";

		}	
	return $cart_data;
}
add_action('admin_menu','add_cart');

add_shortcode('cart_fun','show_cart');


/* End Of Shopping Cart */




//add registration shortcoode

add_shortcode( 'simple-registration-form', 'srf_registration_shortcode' );

add_shortcode( 'simple-login-form', 'login_shortcode' );
	

?>
