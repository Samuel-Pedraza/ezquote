<?php
/**
 * Plugin Name: ezquote
 * Description: Alpha Version of EZQuote
 * Version: 0.0.1
 * Author: Samuel Pedraza
 */

function my_scripts(){
	wp_register_style('mainCSS', '/wp-content/plugins/ezquote/css/main.css');
	wp_register_style('fontawesome', 'https://use.fontawesome.com/releases/v5.1.0/css/all.css');
	wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
	wp_register_script('mainJS', '/wp-content/plugins/ezquote/js/main.js');
	
	wp_enqueue_style('mainCSS');
	wp_enqueue_style('fontawesome');
	wp_enqueue_style('bootstrap');
	wp_enqueue_script('mainJS');
}

function ezquote(){
	my_scripts();
	?>
	<div class="ezquote-container" id="show-quote-form">
			<h3>Quick Quote</h3>
		<div class="form-for-quote">
			<form method="POST" action="<?php echo admin_url( 'admin-post.php' ); ?>" class="p-3">
				<input type="hidden" name="action" value="ezquotesubmit">
				<div class="form-group">
					<input type="text" name="location" class="form-control" placeholder="Address">
				</div>
				<div class="form-group">
					<input type="text" name="name" class="form-control" placeholder="Name - Company">
				</div>
				<div class="form-group">
					<input type="text" name="product" class="form-control" placeholder="Product">
				</div>
				<div class="form-group">
					<input type="text" name="amount" class="form-control" placeholder="Amount">
				</div>
				<div class="form-group">
					<input type="submit">
				</div>
			</form>			
		</div>
	</div>
	<?php
}

function mail_submissions(){
	$location = sanitize_text_field($_POST['location']);
	$name = sanitize_text_field($_POST['name']);
	$product = sanitize_text_field($_POST['product']);
	$amount = sanitize_text_field($_POST['amount']);
	
	$headers = array('Content-Type: text/html; charset=UTF-8');

	$message = $location . $name . $product . $amount;

	$send_mail = wp_mail("samdpedraza@gmail.com", "Quote Submitted!", $message, $headers);

	if($send_mail){
		echo "yup";
	} else {
		echo "nope";
	}

	return wp_redirect("/");
}

add_shortcode('ezquote_plugin', 'ezquote');
add_action('wp_head', 'my_scripts');
add_action( 'admin_post_nopriv_ezquotesubmit', 'mail_submissions' );
add_action( 'admin_post_ezquotesubmit', 'mail_submissions' );