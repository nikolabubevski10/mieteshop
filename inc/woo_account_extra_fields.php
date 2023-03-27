<?php
/**
 * @snippet       File Upload @ WooCommerce My Account Registration
 */
 
// --------------
// 1. Add custom fields to register form
/* 
add_action( 'woocommerce_register_form', 'miet_add_woo_account_registration_fields' );
function miet_add_woo_account_registration_fields() {
   ?>
    
    <p class="woocommerce-form-row validate-required" id="dropdown" data-priority="">
    <label for="reg_role"><?php _e( 'Επιλέξτε ρόλο', 'woocommerce' ); ?></label>
    <select class="input-text" name="register_role" id="reg_role"> 
      <option <?php if ( ! empty( $_POST['register_role'] ) && $_POST['register_role'] == 'customer') esc_attr_e( 'selected' ); ?> value="customer">Πελάτης</option> 
      <option value="students">Φοιτητής</option>
      <option value="teachers">Εκπαιδευτικός</option>
      <!--option value="ete_employees">Υπάλληλος ΕΤΕ</option-->
    </select>
    </p>

    <p class="woocommerce-form-row validate-required fieldStudentPaso" id="student_paso" data-priority="">
        <label for="student_paso" class="">Εικόνα (JPG, PNG) ή PDF)<abbr class="required" title="required">*</abbr></label>
        <span class="woocommerce-input-wrapper"><input type='file' name='fld_student_paso' id='fld_student_paso' accept='image/*,.pdf'></span>
        <label for="student_paso" style="padding-top:10px;">Επισυνάψτε αντίγραφο του φοιτητικού πάσο σας για να έχετε πρόσβαση στις εκπτώσεις των εκδόσεων ΜΙΕΤ. <a href="#">Διάβαστε περισσότερα</a></label>
    </p>

    <p class="woocommerce-form-row validate-required fieldStudentPaso" id="student_paso" data-priority="">
        <label for="student_paso" class="">Εικόνα (JPG, PNG) ή PDF)<abbr class="required" title="required">*</abbr></label>
        <span class="woocommerce-input-wrapper"><input type='file' name='fld_student_paso' id='fld_student_paso' accept='image/*,.pdf'></span>
        <label for="student_paso" style="padding-top:10px;">Επισυνάψτε αντίγραφο του φοιτητικού πάσο σας για να έχετε πρόσβαση στις εκπτώσεις των εκδόσεων ΜΙΕΤ. <a href="#">Διάβαστε περισσότερα</a></label>
    </p>    
    
    <!--p class="woocommerce-form-row validate-required fieldETEemployeeCode" id="ETE_employee_code" data-priority="">
         <label for="ETE_employee_code" class="">Αριθμός Μητρώου Υπαλλήλου Ε.Τ.Ε.<abbr class="required" title="required">*</abbr></label>
         <span class="woocommerce-input-wrapper"><input type='text' name='fld_ete_employee_code' id='fld_ete_employee_code'></span>
         <label for="ETE_employee_code" style="padding-top:10px;">Ο αριθμός μητρώου είναι απαραίτητος για να έχετε πρόσβαση στις εκπτώσεις των εκδόσεων ΜΙΕΤ. <a href="/ekptoseis-gia-trapezikous/" target="_blank">Διαβάστε περισσότερα</a></label>
   </p-->
   <?php
}

// --------------
// Display fields in edit account
add_action( 'woocommerce_edit_account_form', 'miet_display_account_registration_fields' );
function miet_display_account_registration_fields() {
   $userid = get_current_user_id(); //wp_get_current_user();

   if( current_user_can('ete_employees') ) {
   ?> 
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" id="ETE_employee_code" data-priority="">
      <?php $arithmos_mitroou = get_user_meta( $userid, 'fld_ete_employee_code', true ); ?>
      <label for="ETE_employee_code" class="">Αριθμός Μητρώου Υπαλλήλου Ε.Τ.Ε.</label>
      <span class="woocommerce-input-wrapper"><?php echo $arithmos_mitroou; ?></span> 
   </p>
   <?php
   //} elseif (current_user_can('students')) {
   }

}


// --------------
// 2. Validate new fields
 
add_filter( 'woocommerce_process_registration_errors', 'miet_validate_woo_account_registration_fields', 10, 3 );
function miet_validate_woo_account_registration_fields( $errors, $username, $email ) {
   //if (!isset($_POST['register_role']) || empty($_POST['register_role']) ) {
   //     $errors->add('role_error', __('Επιλέξτε ρόλο', 'woocommerce'));
   //}

   switch ($_POST['register_role']) {
      case 'students':
         if ( empty( $_FILES['fld_student_paso'] ) ) {
            $errors->add( 'student_paso_error', __( 'Ανεβάστε ένα έγκυρο τύπο αρχείου (JPG, PNG ή PDF)', 'woocommerce' ) );
         }
         break;      
      case 'ete_employees':
         if( empty( $_POST['fld_ete_employee_code'] ) ) {
            $errors->add( 'employee_code_error', __( 'Συμπληρώστε έναν Αριθμό Μητρώου', 'woocommerce' ) );
         }   
         break;         
   }
   //if ( isset($_POST['register_role']) && $_POST['register_role'] == 'students' && isset( $_POST['input_student_paso'] ) && empty( $_POST['input_student_paso'] ) ) {
   //    $errors->add( 'image_error', __( 'Ανεβάστε ένα έγκυρο τύπο αρχείου (JPG, PNG ή PDF)', 'woocommerce' ) );
   //}

   //if ( isset($_POST['register_role']) && $_POST['register_role'] == 'ete_employees' && isset( $_POST['input_ETE_employee_code'] ) && empty( $_POST['input_ETE_employee_code'] ) ) {
   //   $errors->add( 'employee_code_error', __( 'Συμπληρώστε έναν Αριθμό Μητρώου', 'woocommerce' ) );
   //}    

    return $errors;
}
 
// --------------
// 3. Save new fields
 
add_action( 'user_register', 'miet_save_woo_account_registration_fields', 1 );
function miet_save_woo_account_registration_fields( $customer_id ) {
   $user = new WP_User( $customer_id );

   //Role field
   if (isset($_POST['register_role'])) {
      //update_user_meta($customer_id, 'role', sanitize_text_field($_POST['register_role']));
      $user->remove_role( 'customer' ); 
      $user->add_role( $_POST['register_role'] );      
   }

   //student paso field
   if ( isset( $_FILES['fld_student_paso'] ) ) {
      require_once( ABSPATH . 'wp-admin/includes/image.php' );
      require_once( ABSPATH . 'wp-admin/includes/file.php' );
      require_once( ABSPATH . 'wp-admin/includes/media.php' );
      $attachment_id = media_handle_upload( 'image', 0 );
      if ( is_wp_error( $attachment_id ) ) {
         update_user_meta( $customer_id, 'image', $_FILES['input_student_paso'] . ": " . $attachment_id->get_error_message() );
      } else {
         update_user_meta( $customer_id, 'image', $attachment_id );
      }
   }

   if ( isset( $_POST['fld_ete_employee_code'] ) ) {
      update_user_meta($customer_id, 'fld_ete_employee_code', $_POST['fld_ete_employee_code'] );
   }   

   //if (isset($_POST['register_role'])) {
   //   update_user_meta($customer_id, 'role', sanitize_text_field($_POST['register_role']));
   //}   
}
 
// --------------
// 4. Add enctype to form to allow image upload
 
add_action( 'woocommerce_register_form_tag', 'miet_enctype_custom_registration_forms' );
 
function miet_enctype_custom_registration_forms() {
   echo 'enctype="multipart/form-data"';
}
*/
?>