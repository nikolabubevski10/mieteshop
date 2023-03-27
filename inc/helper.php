<?php

require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(dirname(dirname(__FILE__)) . '/twig-templates');
global $twig;
$twig = new \Twig\Environment($loader);

$twigAddToFavoriteButtonFunction = new \Twig\TwigFunction('addToFavoriteButton', function ($product_id) {
  global $post; 
  $post = get_post( $product_id, OBJECT );
  setup_postdata( $post );

  $wishlist_button =  do_shortcode('[yith_wcwl_add_to_wishlist]');
  
  wp_reset_postdata();

  return $wishlist_button;
});
$twig->addFunction($twigAddToFavoriteButtonFunction);

/**
 * Create a web friendly URL slug from a string.
 * 
 * Although supported, transliteration is discouraged because
 *     1) most web browsers support UTF-8 characters in URLs
 *     2) transliteration causes a loss of information
 *
 * @author Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license http://creativecommons.org/publicdomain/zero/1.0/
 *
 * @param string $str
 * @param array $options
 * @return string
 */
function url_slug($str, $options = array()) {
	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
	
	$defaults = array(
		'delimiter' => '-',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => false,
	);
	
	// Merge options
	$options = array_merge($defaults, $options);
	
	$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
		'ß' => 'ss', 
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
		'ÿ' => 'y',

		// Latin symbols
		'©' => '(c)',

		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',

		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
		'Ž' => 'Z', 
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z', 

		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
		'Ż' => 'Z', 
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',

		// Latvian
		'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
		'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
		'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
		'š' => 's', 'ū' => 'u', 'ž' => 'z'
	);
	
	// Make custom replacements
	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
	
	// Transliterate characters to ASCII
	if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
	}
	
	// Replace non-alphanumeric characters with our delimiter
	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	
	// Remove duplicate delimiters
	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
	
	// Truncate slug to max. characters
	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
	
	// Remove delimiter from ends
	$str = trim($str, $options['delimiter']);
	
	return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}


/* code to override get_price_html() 
not sure if this works if the woocommerce tax settings are set to "No, I will enter prices exclusive of tax". 
The price displays excluding the taxes but it should show with the taxes. I have to check this.
*/
/*
if (!function_exists('my_commonPriceHtml')) {

    function my_commonPriceHtml($price_amt, $regular_price, $sale_price) {
        $html_price = '<p class="price">';
		//echo $price_amt.' > '.$regular_price.' - '.$sale_price.' # ';

        //if product is on sale
        if (($price_amt == $sale_price) && ($sale_price != 0)) {
            $html_price .= '<del>' . wc_price($regular_price) . '</del>';
			      $html_price .= '<ins>' . wc_price($sale_price) . '</ins>';
			      $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';
			      $html_price .= '<span class="book-product-discount">'.$saving_percentage.'</span>';
        }
        //in sale but free
        else if (($price_amt == $sale_price) && ($sale_price == 0)) {
            if($regular_price > 0) {
              $html_price .= '<del>' . wc_price($regular_price) . '</del>';
            }  
			      $html_price .= '<ins>Μη διαθέσιμο</ins>';
        }
        //not on sale
        else if (($price_amt == $regular_price) && ($regular_price != 0)) {
            $html_price .= '<ins>' . wc_price($regular_price) . '</ins>';
        }
        //for free product
        else if (($price_amt == $regular_price) && ($regular_price == 0)) {
            $html_price .= '<ins>Μη διαθέσιμο</ins>';
        }
        $html_price .= '</p>';
        return $html_price;
    }

}
*/

/*
add_filter('woocommerce_get_price_html', 'my_simple_product_price_html', 100, 2);
function my_simple_product_price_html($price, $product) {
    if ($product->is_type('simple')) {
        $regular_price = $product->get_regular_price();
        $woo_sale_price = $product->get_sale_price();

		//Since rules are applied during runtime, we need to use filters to get woo discount rules discount price - if any - 
		///$discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', false, $product, 1, 0, 'all', true);
		$discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', $product->get_price(), $product, 1, 0, 'discounted_price', true);
		//echo $discounted_price .'--';

		if ($discounted_price !== false) {
				//if ($discounted_price['discounted_price']  > 0) { //woo discount rule
			$sale_price = $discounted_price;
		} else { 
			$sale_price = $woo_sale_price; //woo discount rules returns false so get woocommerce sale_price 
		}

        $price_amt = $product->get_price();
        return my_commonPriceHtml($price_amt, $regular_price, $sale_price);
    } else {
        return $price;
    }
}
*/

/*
add_filter('woocommerce_variation_sale_price_html', 'my_variable_product_price_html', 10, 2);
add_filter('woocommerce_variation_price_html', 'my_variable_product_price_html', 10, 2);
function my_variable_product_price_html($price, $variation) {
    $variation_id = $variation->variation_id;
    //creating the product object
    $variable_product = new WC_Product($variation_id);

    $regular_price = $variable_product->get_regular_price();
    $sale_price = $variable_product->get_sale_price();
    $price_amt = $variable_product->get_price();

    return my_commonPriceHtml($price_amt, $regular_price, $sale_price);
}

add_filter('woocommerce_variable_sale_price_html', 'my_variable_product_minmax_price_html', 10, 2);
add_filter('woocommerce_variable_price_html', 'my_variable_product_minmax_price_html', 10, 2);
function my_variable_product_minmax_price_html($price, $product) {
    $variation_min_price = $product->get_variation_price('min', true);
    $variation_max_price = $product->get_variation_price('max', true);
    $variation_min_regular_price = $product->get_variation_regular_price('min', true);
    $variation_max_regular_price = $product->get_variation_regular_price('max', true);

    if (($variation_min_price == $variation_min_regular_price) && ($variation_max_price == $variation_max_regular_price)) {
        $html_min_max_price = $price;
    } else {
        $html_price = '<p class="price">';
        $html_price .= '<ins>' . wc_price($variation_min_price) . '-' . wc_price($variation_max_price) . '</ins>';
        $html_price .= '<del>' . wc_price($variation_min_regular_price) . '-' . wc_price($variation_max_regular_price) . '</del>';
        $html_min_max_price = $html_price;
    }

    return $html_min_max_price;
}
*/

/*
// custom fields for registration

function wooc_extra_register_fields() {
	?>

	<script type="text/javascript">
	function regTypeChange(event) {
		var reg_type = document.getElementById("reg_register_type");
		var reg_val  = reg_type.options[ reg_type.selectedIndex ].value;

		var paso = document.getElementById("form-paso");
		var inst = document.getElementById("form-institution");

		switch ( reg_val ) {
		case 'student':
			paso.style.display = "block";
			inst.style.display = "block";
			break;
		case 'professor':
			paso.style.display = "none";
			inst.style.display = "block";
			break;
		case 'customer':
		default:
			paso.style.display = "none";
			inst.style.display = "none";
			break;
		}
	}
	</script>

	<div class="form-group" id="form-register_type">
		<label for="register_type" class="inline">Είμαι</label>
		<select class="inline" id="reg_register_type" name="register_type" required onchange="regTypeChange(event);">
			<option value="customer">Πελάτης</option>
			<option value="professor">Καθηγητής</option>
			<option value="student">Φοιτητής</option>
		</select>
	</div>

	<div class="form-group form-row" id="form-paso">
		<label for="reg_paso">Κωδικός φοιτητικού πάσο <span class="required">*</span></label>
		<input type="text" class="input-text" name="paso" id="reg_paso" size="30" value="<?php esc_attr($_POST['paso']); ?>" />
		<p class="text-muted small">Απαραίτητος λόγω των προσφορών που λαμβάνουν οι φοιτητές</p>
	</div>

	<div class="form-group form-row" id="form-institution">
		<label for="reg_institution">Ίδρυμα - Τμήμα <span class="required">*</span></label>
		<select class="" id="reg_institution" name="institution" required>
			<option value="ΧΑΡΟΚΟΠΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ">ΧΑΡΟΚΟΠΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ</option>
			<option value="ΤΕΧΝΟΛΟΓΙΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ">ΤΕΧΝΟΛΟΓΙΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ</option>
			<option value="ΤΕΙ ΣΤΕΡΕΑΣ ΕΛΛΑΔΑΣ">ΤΕΙ ΣΤΕΡΕΑΣ ΕΛΛΑΔΑΣ</option>
			<option value="ΤΕΙ ΠΕΛΟΠΟΝΝΗΣΟΥ">ΤΕΙ ΠΕΛΟΠΟΝΝΗΣΟΥ</option>
			<option value="ΤΕΙ ΠΕΙΡΑΙΑ">ΤΕΙ ΠΕΙΡΑΙΑ</option>
			<option value="ΤΕΙ ΚΡΗΤΗΣ">ΤΕΙ ΚΡΗΤΗΣ</option>
			<option value="ΤΕΙ ΚΕΝΤΡΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ">ΤΕΙ ΚΕΝΤΡΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ</option>
			<option value="ΤΕΙ ΙΟΝΙΩΝ ΝΗΣΩΝ">ΤΕΙ ΙΟΝΙΩΝ ΝΗΣΩΝ</option>
			<option value="ΤΕΙ ΘΕΣΣΑΛΙΑΣ">ΤΕΙ ΘΕΣΣΑΛΙΑΣ</option>
			<option value="ΤΕΙ ΗΠΕΙΡΟΥ">ΤΕΙ ΗΠΕΙΡΟΥ</option>
			<option value="ΤΕΙ ΔΥΤΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ">ΤΕΙ ΔΥΤΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ</option>
			<option value="ΤΕΙ ΔΥΤΙΚΗΣ ΕΛΛΑΔΑΣ">ΤΕΙ ΔΥΤΙΚΗΣ ΕΛΛΑΔΑΣ</option>
			<option value="ΤΕΙ ΑΝΑΤΟΛΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ ΚΑΙ ΘΡΑΚΗΣ">ΤΕΙ ΑΝΑΤΟΛΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ ΚΑΙ ΘΡΑΚΗΣ</option>
			<option value="ΤΕΙ ΑΘΗΝΑΣ">ΤΕΙ ΑΘΗΝΑΣ</option>
			<option value="ΠΑΝΤΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΟΙΝΩΝΙΚΩΝ ΚΑΙ ΠΟΛΙΤΙΚΩΝ ΕΠΙΣΤΗΜΩΝ">ΠΑΝΤΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΟΙΝΩΝΙΚΩΝ ΚΑΙ ΠΟΛΙΤΙΚΩΝ ΕΠΙΣΤΗΜΩΝ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΣΤΕΡΕΑΣ ΕΛΛΑΔΑΣ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΣΤΕΡΕΑΣ ΕΛΛΑΔΑΣ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΠΕΛΟΠΟΝΝΗΣΟΥ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΠΕΛΟΠΟΝΝΗΣΟΥ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΠΕΙΡΑΙΩΣ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΠΕΙΡΑΙΩΣ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΠΑΤΡΩΝ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΠΑΤΡΩΝ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΝΕΑΠΟΛΗΣ ΠΑΦΟΥ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΝΕΑΠΟΛΗΣ ΠΑΦΟΥ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΜΑΚΕΔΟΝΙΑΣ ΟΙΚΟΝΟΜΙΚΩΝ ΚΑΙ ΚΟΙΝΩΝΙΚΩΝ ΕΠΙΣΤΗΜΩΝ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΜΑΚΕΔΟΝΙΑΣ ΟΙΚΟΝΟΜΙΚΩΝ ΚΑΙ ΚΟΙΝΩΝΙΚΩΝ ΕΠΙΣΤΗΜΩΝ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΛΕΥΚΩΣΙΑΣ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΛΕΥΚΩΣΙΑΣ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΡΗΤΗΣ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΡΗΤΗΣ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΙΩΑΝΝΙΝΩΝ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΙΩΑΝΝΙΝΩΝ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΘΕΣΣΑΛΙΑΣ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΘΕΣΣΑΛΙΑΣ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΔΥΤΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΔΥΤΙΚΗΣ ΜΑΚΕΔΟΝΙΑΣ</option>
			<option value="ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΙΓΑΙΟΥ">ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΙΓΑΙΟΥ</option>
			<option value="ΟΙΚΟΝΟΜΙΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΘΗΝΩΝ">ΟΙΚΟΝΟΜΙΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΘΗΝΩΝ</option>
			<option value="ΙΟΝΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ">ΙΟΝΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ</option>
			<option value="ΕΥΡΩΠΑΪΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ">ΕΥΡΩΠΑΪΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ</option>
			<option value="ΕΛΛΗΝΙΚΟ ΑΝΟΙΧΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ">ΕΛΛΗΝΙΚΟ ΑΝΟΙΧΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ</option>
			<option value="ΕΘΝΙΚΟ ΚΑΙ ΚΑΠΟΔΙΣΤΡΙΑΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΘΗΝΩΝ">ΕΘΝΙΚΟ ΚΑΙ ΚΑΠΟΔΙΣΤΡΙΑΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΘΗΝΩΝ</option>
			<option value="ΔΙΕΘΝΕΣ ΠΑΝΕΠΙΣΤΗΜΙΟ ΕΛΛΑΔΟΣ">ΔΙΕΘΝΕΣ ΠΑΝΕΠΙΣΤΗΜΙΟ ΕΛΛΑΔΟΣ</option>
			<option value="ΔΗΜΟΚΡΙΤΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΘΡΑΚΗΣ">ΔΗΜΟΚΡΙΤΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΘΡΑΚΗΣ</option>
			<option value="ΓΕΩΠΟΝΙΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΘΗΝΩΝ">ΓΕΩΠΟΝΙΚΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΑΘΗΝΩΝ</option>
			<option value="ΑΡΙΣΤΟΤΕΛΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΘΕΣΣΑΛΟΝΙΚΗΣ">ΑΡΙΣΤΟΤΕΛΕΙΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΘΕΣΣΑΛΟΝΙΚΗΣ</option>
			<option value="ΑΝΟΙΚΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ">ΑΝΟΙΚΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ ΚΥΠΡΟΥ</option>
			<option value="Άλλο">Άλλο</option>
		</select>
	</div>

	<?php
}
add_action( 'woocommerce_register_form', 'wooc_extra_register_fields' );

function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
	$reg_type = $_POST['register_type'];

	if ( $reg_type ) switch ( $reg_type ) {
	case 'student':
		if ( empty( $_POST['paso'] ) ) {
			$validation_errors->add( 'paso_error', __( 'Το πεδίο "Κωδικός φοιτητικού πάσο" είναι απαραίτητο!', 'woocommerce' ) );
		}
		if ( empty( $_POST['institution'] ) ) {
			$validation_errors->add( 'inst_error', __( 'Το πεδίο "Ίδρυμα - Τμήμα" είναι απαραίτητο!', 'woocommerce' ) );
		}
		break;
	case 'professor':
		if ( empty( $_POST['institution'] ) ) {
			$validation_errors->add( 'inst_error', __( 'Το πεδίο "Ίδρυμα - Τμήμα" είναι απαραίτητο!', 'woocommerce' ) );
		}
		break;
	case 'customer':
	default:
		break;
	}
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

function wooc_save_extra_register_fields( $customer_id ) {
	$reg_type = $_POST['register_type'];

	if ( $reg_type) switch ( $reg_type ) {
	case 'student':
		if ( isset( $_POST['paso'] ) ) {
			update_user_meta( $customer_id, 'paso', sanitize_text_field( $_POST['paso'] ) );
		}
		if ( isset( $_POST['institution'] ) ) {
			update_user_meta( $customer_id, 'institution', sanitize_text_field( $_POST['institution'] ) );
		}

		// add user to proper group
		$group = Groups_Group::read_by_name( 'Φοιτητές' );
		Groups_User_Group::create(
			array(
				'group_id' => $group->group_id,
				'user_id'  => $customer_id
			)
		);
		break;
	case 'professor':
		if ( isset( $_POST['institution'] ) ) {
			update_user_meta( $customer_id, 'institution', sanitize_text_field( $_POST['institution'] ) );
		}

		// add user to proper group
		$group = Groups_Group::read_by_name( 'Καθηγητές' );
		Groups_User_Group::create(
			array(
				'group_id' => $group->group_id,
				'user_id'  => $customer_id
			)
		);
		break;
	case 'customer':
	default:
		break;
	}
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
*/



