<?php
/**
 * Marketplace for WooCommerce - Email
 *
 * @version 1.2.3
 * @since   1.2.3
 * @author  Algoritmika Ltd.
 */

if ( ! class_exists( 'Alg_MPWC_Email' ) ) {
	class Alg_MPWC_Email {

		/**
		 * Replaces template variables
		 *
		 * @version 1.2.5
		 * @since   1.2.5
		 *
		 * @param $message
		 *
		 * @return mixed
		 */
		public static function replace_template_variables( $message, $order = "" ) {
			$order_date = '';
			if ( ! empty( $order ) ) {
				$order_date = wc_format_datetime( $order->get_date_created() );
			}
			return str_replace( array(
				'{site_title}',
				'{order_date}',
			), array(
				wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ),
				$order_date
			), $message );
		}

		/**
		 * Get email template
		 * @version 1.2.5
		 * @since   1.2.3
		 *
		 * @param $content
		 * @param string $email_heading
		 *
		 * @return string
		 */
		public static function wrap_in_wc_email_template( $content, $email_heading = '' ) {
			return self::get_wc_email_part( 'header', $email_heading ) .
			       $content .
			       self::replace_template_variables( self::get_wc_email_part( 'footer' ) );
		}

		/**
		 * Gets email part
		 *
		 * @version 1.2.3
		 * @since   1.2.3
		 *
		 * @param $part
		 * @param string $email_heading
		 *
		 * @return false|string
		 */
		public static function get_wc_email_part( $part, $email_heading = '' ) {
			ob_start();
			switch ( $part ) {
				case 'header':
					wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) );
				break;
				case 'footer':
					wc_get_template( 'emails/email-footer.php' );
				break;
			}
			return ob_get_clean();
		}

	}
}