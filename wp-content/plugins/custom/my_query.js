
var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);
function fetch_posts_forhis_cat(obj=''){

  $cat_id = obj.value;

    $.ajax({
        type: "POST",
        url: ajax_object.ajaxurl,
        data: {
            action: 'fetch_posts_forhis_category',
            cid: $cat_id // <-- category ID of clicked item / link
        },
        success: function( response ) {
           $new_res = JSON.parse(response);
        //    console.log($new_res);
        $("#vehicle_name_select").html('');
        $("#vehicle_name_select").html('<option >Select Vehicle</option>');
            $.each( $new_res, function( key, value ) {
                console.log( key, value ); 
              
                $("#vehicle_name_select").append('<option value='+value.ID+' >'+value.post_title+'</option>');
                
                // that's the posts data.
            } );
        }
    })

}


function fetch_price_forhis_post(obj=''){

    $post_id = obj.value;
  
      $.ajax({
          type: "POST",
          url: ajax_object.ajaxurl,
          data: {
              action: 'fetch_price_forhis_post',
              postid: $post_id // <-- category ID of clicked item / link
          },
          success: function( response ) {
          $("#price_product").val('$'+response+'.00');
           
        
          }
      })
  
  }

 
  function update_status(obj='',cust_id=''){

    $status = obj.value;
  
      $.ajax({
          type: "POST",
          url: ajax_object.ajaxurl,
          data: {
              action: 'update_status',
              customerid :cust_id,
              status:$status
               // <-- category ID of clicked item / link
          },
          success: function( response ) {
          
           location.reload();
        
          }
      });
   
  
  } 