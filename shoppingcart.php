<?php 
/*
	Template Name:Shopping Cart
*/

/* Check Login */

//$user = wp_get_current_user();

/* if ( ! is_admin() ) {
  echo '<p>adsense!</p>';
}
else 
{
	echo "Normal User";	
}*/

/*
if ( is_user_logged_in() ) {
    echo 'Welcome, registered user!';
} else {
    echo 'Welcome, visitor!';
}
*/

/*
print $user;
die;*/
/*
if ( in_array( 'admin', (array) $user->roles ) ) {
    //The user has the "author" role
	
	
	echo "hello User";
}*/


//add_action();

//ini_set('display_errors', 0); 


	get_header();
	

global $wpdb;

?>

<html>
	<form name="cart_form" id="cart_form" method="post">
		<label>Product Name:--></label>
			<?php 
				echo do_shortcode("[cart_fun]");
			?>
		<label>Product Image</label>
			
	</form>
</html>