(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function(){
		$('.woocommerce-firebase-login-toggle .showfirebaselogin').on('click', function(e){
			e.preventDefault();
			$('form.woocommerce-firebse-login').toggle();
		});

		/**
		 * Validate firebase login form fields
		 */
		$( "form.woocommerce-firebse-login" ).validate({
			rules: {
				firebase_email: {
					required: true,
					email: true
				},
				firebase_password: {
					required: true,
				}
			},
			messages: {
				firebase_email: "Please enter a valid email address",
				firebase_password: "Please enter password"
			},
			errorElement: "em",
			errorPlacement: function ( error, element ) {
				// Add the `invalid-feedback` class to the error element.
				error.addClass( "invalid-feedback" );

				if ( element.prop( "type" ) === "checkbox" ) {
					error.insertAfter( element.next( "label" ) );
				} else {
					error.insertAfter( element );
				}
			},
			highlight: function ( element, errorClass, validClass ) {
				$( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
			},
			unhighlight: function (element, errorClass, validClass) {
				$( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
			},
			submitHandler: function(form) {
				
				$('.woocommerce-checkout .cms-firebse-login-loader').show();

				var firebase_form_nfield = $( '#firebase_form_nfield' ).val();
				var firebase_email       = $( '#firebase_email' ).val();
				var firebase_password    = $( '#firebase_password' ).val();

				$.ajax({
					type: 'post',
					dataType: 'json',
					url: ajax_url.url,
					data: {
						action: 'cms_firebase_form_submit',
						firebase_form_nfield: firebase_form_nfield,
						firebase_email: firebase_email,
						firebase_password: firebase_password
					},
					success: function ( response ) {
						
						if ( response.success ) {
							$( '.woocommerce-checkout .cms-firebse-login-loader' ).hide();
							$( '.woocommerce-firebase-login-toggle, .woocommerce-firebse-login' ).hide();
							location.reload();
						} else {
							$( '.woocommerce-checkout .cms-firebse-login-notices' ).addClass( 'error' );
							$( '.woocommerce-checkout .cms-firebse-login-notices' ).css( "border", "2px solid red" ).html( '<p>' + response.error + '</p>' );
							$( '.woocommerce-checkout .cms-firebse-login-notices' ).show();
						}
					}
				});

				return false;  // block the default submit action
			}
		});
	});

})( jQuery );
