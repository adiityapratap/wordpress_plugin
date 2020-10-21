<?php
/*
Plugin Name: Booking
Description: Custom Booking Form
Version: 1.0
Author: Aditya

*/
global $wpdb; 
add_action('admin_menu', 'test2');



function html_form_code() {
    wp_enqueue_script( 'ajax-script', plugins_url( '/my_query.js', __FILE__ ), array('jquery') );
    wp_register_script( 
        'ajaxHandle', 
        plugins_url('/my_query.js', __FILE__), 
        array(), 
        false, 
        true 
      );
      wp_enqueue_script( 'ajaxHandle' );
      wp_localize_script( 
        'ajaxHandle', 
        'ajax_object', 
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) 
      );

    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p class="width-50 left-float">';
    echo 'First Name <span class="ct-red">*</span><br />';
    echo '<input type="text" name="cf-first_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-first_name"] ) ? esc_attr( $_POST["cf-first_name"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p class="width-50 right-float">';
    echo 'Last Name <span class="ct-red">*</span><br />';
    echo '<input type="text" name="cf-last_name" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-last_name"] ) ? esc_attr( $_POST["cf-last_name"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p class="width-50 left-float">';
    echo 'Your Email <span class="ct-red">*</span><br />';
    echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p class="width-50 right-float">';
    echo 'Phone <span class="ct-red">*</span> <br />';
    echo '<input type="text" name="cf-phone" value="' . ( isset( $_POST["cf-phone"] ) ? esc_attr( $_POST["cf-phone"] ) : '' ) . '" size="40" />';
    echo '</p>';
    echo '<p class="width-100">';
    echo 'Vehicle Type <span class="ct-red">*</span> <br />';
    echo '<select name="cf-vehicle_type" onChange="fetch_posts_forhis_cat(this)" id="vhicle_type">'; 
    echo '<option value="">Select Category</option>'; 

        $categories = get_categories( array(
            'orderby' => 'name',
			'order'   => 'ASC'
		) );
		
        foreach ($categories as $category) {
            $option .= '<option value="'.$category->term_id.'">';
            $option .= $category->cat_name;
            $option .= '</option>';
        }
        echo $option;
    echo '</select>';
    echo '</p>';
    echo '<p class="width-100">';
    echo 'Vehicle <span class="ct-red">*</span><br />';
    echo '<select name="cf-vehicle"  onChange="fetch_price_forhis_post(this)" id="vehicle_name_select">'; 
    echo '<option value="">Select Vehicle</option>'; 

    $args = array(  
        'post_status' => 'publish',
        'orderby' => 'title', 
        'order' => 'ASC', 
    );

    $loop = new WP_Query( $args ); 
    
    while ( $loop->have_posts() ) : $loop->the_post(); 
    $title=get_the_title();
    $id=get_the_ID();
    $option1 .= '<option value="'.$id.'">';
    $option1 .= $title;
    $option1 .= '</option>';
    
    endwhile;

    wp_reset_postdata();
    print $option1;
    echo '</select>';
    echo '</p>';
    echo '<p class="width-100">';
    echo 'Price <span class="ct-red">*</span><br />';
    echo '<input type="text" name="cf-price"  id="price_product"value="" readonly size="40" />';
    echo '</p>';
    echo '<p class="width-100">';
    echo 'Your Message <br />';
    echo '<textarea rows="3" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="cf-submitted" value="Send"/></p>';
    echo '</form>';
    
    

}
function deliver_mail() {
    global $wpdb;
    // if the submit button is clicked, send the email
    if ( isset( $_POST['cf-submitted'] ) ) {
        
        // sanitize form values
        $first_name    = sanitize_text_field( $_POST["cf-first_name"] );
        $last_name = sanitize_text_field( $_POST["cf-last_name"] );
        $email   = sanitize_email( $_POST["cf-email"] );
        $phone = sanitize_text_field( $_POST["cf-phone"] );
        $vehicle_type = sanitize_text_field( $_POST["cf-vehicle_type"] );
        $vehicle = sanitize_text_field( $_POST["cf-vehicle"] );
        $price = sanitize_text_field( $_POST["cf-price"] );
        $message = esc_textarea( $_POST["cf-message"] );

        
        $tbl_name = $wpdb->prefix.'booking_form'; 
        $kv_data = array( 
            'first_name' => $first_name, 
            'last_name' => $last_name,
            'email'	=> $email, 
            'phone' => $phone,
            'vehicle_type' => $vehicle_type,
            'vehicle' => $vehicle,
            'price' => $price,
            'message' 	=> $message 
        ) ; 		
        $wpdb->insert( $tbl_name, $kv_data );
        
        
        // email to customer
        $to = $email ;
        $subject ="Thanks for Booking";
        $message = "Thankyou for booking. Your order status is pending";
        $headers[] = 'From: Aditya <adityakohli467@gmail.com>';
        wp_mail( $to, $subject, $message, $headers );

        // email to admin
        $toadmin = get_option( 'admin_email' );
        $subjectadmin ="Order Booking Request";
        $messageadmin = $first_name. " is requested for booking ".$vehicle;
        $headers1[] = 'From: Aditya <adityakohli467@gmail.com>';
        wp_mail( $toadmin, $subjectadmin, $messageadmin, $headers1 );
        
       
        //$headers = "From: $name <$email>" . "\r\n";

        // If email has been process for sending, display a success message
        /*if ( mail($to, 'php wala mail', $message)) {
            echo '<div>';
            echo '<p>Thanks for contacting me, expect a response soon.</p>';
            echo '</div>';
        } else {
            // mail($to, 'php wala mail', $message);
            echo 'An unexpected error occurred';
        } */
    }
}
function test_init(){
    global $wpdb;
    wp_enqueue_script( 'ajax-script', plugins_url( '/my_query.js', __FILE__ ), array('jquery') );

    wp_register_script( 
        'ajaxHandle', 
        plugins_url('/my_query.js', __FILE__), 
        array(), 
        false, 
        true 
      );
      wp_enqueue_script( 'ajaxHandle' );
      wp_localize_script( 
        'ajaxHandle', 
        'ajax_object', 
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) 
      );
    $tbl_name = $wpdb->prefix.'booking_form'; 
  
    $retrieve_data = $wpdb->get_results( "SELECT * FROM `$tbl_name`" );
    $table='<div class="wrap"><table border="0" class="wp-list-table widefat fixed striped users">
    <tr>
    <thead>
     <th>First Name</th>
     <th>Last Name</th>
     <th style="width: 20%;">Email</th>
     <th>Phone</th>
     <th>Vehicle Type</th>
     <th>Vehicle</th>
     <th>Price</th>
     <th>Message</th>
     <th>status</th>
     <thead>
    </tr>
    <tbody>';

    foreach ($retrieve_data as $retrieved_data){

        $tbl_category = $wpdb->prefix.'terms'; 
        $retrieve_category = $wpdb->get_results( "SELECT * FROM `$tbl_category` where term_id = '$retrieved_data->vehicle_type'" );

        $tbl_vehicle = $wpdb->prefix.'posts'; 
        $retrieve_vehicle = $wpdb->get_results( "SELECT * FROM `$tbl_vehicle` where ID = '$retrieved_data->vehicle'" );
        
        
        $table .='<tr>';
        $table .='<td>'.  $retrieved_data->first_name .'</td>';
        $table .='<td>'.  $retrieved_data->last_name .'</td>';
        $table .='<td>'.  $retrieved_data->email .'</td>';
        $table .='<td>'.  $retrieved_data->phone .'</td>';
        $table .='<td>'.  $retrieve_category[0]->name .'</td>';
        $table .='<td>'.  $retrieve_vehicle[0]->post_title .'</td>';
        $table .='<td>'.  $retrieved_data->price .'</td>';
        $table .='<td>'.  $retrieved_data->message .'</td>';
        $table .='<td><select class="stat_Update" onChange=update_status(this,'.$retrieved_data->id.')>';
        if( $retrieved_data->status == 2 ){
            $table .='<option value="2" selected="selected">Pending</option>';
            $table .='<option value="1" >Approved</option>';
            $table .='<option value="0">Reject</option>';
            $table .='<option value="3">On the Way</option>';
            $table .='<option value="4">Completed</option>';
        }
        elseif ($retrieved_data->status == 0) {
            $table .='<option value="1" >Approved</option>';
            $table .='<option value="2" >Pending</option>';
            $table .='<option value="0" selected="selected">Reject</option>';
            $table .='<option value="3">On the Way</option>';
            $table .='<option value="4">Completed</option>';
        }
        elseif ($retrieved_data->status == 3) {
            $table .='<option value="1" >Approved</option>';
            $table .='<option value="2" >Pending</option>';
            $table .='<option value="0">Reject</option>';
            $table .='<option value="3" selected="selected">On the Way</option>';
            $table .='<option value="4">Completed</option>';
        }
        elseif ($retrieved_data->status == 4) {
            $table .='<option value="1" >Approved</option>';
            $table .='<option value="2" >Pending</option>';
            $table .='<option value="0">Reject</option>';
            $table .='<option value="3">On the Way</option>';
            $table .='<option value="4" selected="selected">Completed</option>';
        }
        else{
            $table .='<option value="0" >Reject</option>';
            $table .='<option value="1" selected="selected">Approved</option>';
            $table .='<option value="2" >Pending</option>';
            $table .='<option value="3">On the Way</option>';
            $table .='<option value="4">Completed</option>';
        }
      
        $table .='</select></td>';
        $table .='</tr>';
    }
    $table.=' <tbody></table></div>';
    echo $table;

}
function test2(){
    add_menu_page( 'Test Plugin Page', 'Booking', 'manage_options', 'test-plugin', 'test_init' );
}
function cf_shortcode() {
    ob_start();
    deliver_mail();
   
    
    html_form_code();

    return ob_get_clean();
}

add_shortcode( 'custom_booking_form', 'cf_shortcode' );
?>