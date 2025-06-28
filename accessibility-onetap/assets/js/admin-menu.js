/* eslint no-undef: "off", no-alert: "off" */
( function( $ ) {
	// Function to handle the click event for each box type
	function handleBoxSelection( selector ) {
		const boxElements = $( selector );
		boxElements.click( function() {
			boxElements.removeClass( 'checked' );
			$( this ).addClass( 'checked' );
		} );
	}

	// Apply the function to different box types
	handleBoxSelection( 'tr.icons td .box-setting-option.icons .box-control .boxes .box label' );
	handleBoxSelection( 'tr.size td .box-setting-option.size .box-control .boxes .box label' );
	handleBoxSelection( 'tr.border td .box-setting-option.border .box-control .boxes .box label' );

	// Event to handle click action on specific label elements
	$( 'tr.icons td .box-setting-option.icons .box-control .boxes .box label' ).on( 'click', function() {
		// Get the 'src' attribute from the child <img> element inside the clicked label
		const getImage = $( this ).children().attr( 'src' );

		// Update the 'src' attribute for the image in the 'size' section
		$( 'tr.size td .box-setting-option.size .box-control .boxes .box label img' ).attr( 'src', getImage );

		// Update the 'src' attribute for the image in the 'border' section
		$( 'tr.border td .box-setting-option.border .box-control .boxes .box label img' ).attr( 'src', getImage );
	} );

	// Add 'active' class to the default desktop layout
	$( 'tr.position-top-bottom, tr.position-left-right, tr.widge-position' ).addClass( 'active' );

	// Handle button click events in the device selection box
	$( '.box-setting-option .box-device .boxes button' ).on( 'click', function() {
		$( '.box-setting-option .box-device .boxes button' ).removeClass( 'active' );
		$( this ).addClass( 'active' );

		const getClass = $( this ).attr( 'class' );
		if ( 'desktop active' === getClass ) {
			$( '.box-setting-option .box-device .boxes button.desktop' ).addClass( 'active' );

			$( 'tr.position-top-bottom' ).addClass( 'active' );
			$( 'tr.position-left-right' ).addClass( 'active' );
			$( 'tr.widge-position' ).addClass( 'active' );

			$( 'tr.position-top-bottom-tablet' ).removeClass( 'active' );
			$( 'tr.position-left-right-tablet' ).removeClass( 'active' );
			$( 'tr.widge-position-tablet' ).removeClass( 'active' );

			$( 'tr.position-top-bottom-mobile' ).removeClass( 'active' );
			$( 'tr.position-left-right-mobile' ).removeClass( 'active' );
			$( 'tr.widge-position-mobile' ).removeClass( 'active' );
		} else if ( 'tablet active' === getClass ) {
			$( '.box-setting-option .box-device .boxes button.tablet' ).addClass( 'active' );

			$( 'tr.position-top-bottom' ).removeClass( 'active' );
			$( 'tr.position-left-right' ).removeClass( 'active' );
			$( 'tr.widge-position' ).removeClass( 'active' );

			$( 'tr.position-top-bottom-tablet' ).addClass( 'active' );
			$( 'tr.position-left-right-tablet' ).addClass( 'active' );
			$( 'tr.widge-position-tablet' ).addClass( 'active' );

			$( 'tr.position-top-bottom-mobile' ).removeClass( 'active' );
			$( 'tr.position-left-right-mobile' ).removeClass( 'active' );
			$( 'tr.widge-position-mobile' ).removeClass( 'active' );
		} else if ( 'mobile active' === getClass ) {
			$( '.box-setting-option .box-device .boxes button.mobile' ).addClass( 'active' );

			$( 'tr.position-top-bottom' ).removeClass( 'active' );
			$( 'tr.position-left-right' ).removeClass( 'active' );
			$( 'tr.widge-position' ).removeClass( 'active' );

			$( 'tr.position-top-bottom-tablet' ).removeClass( 'active' );
			$( 'tr.position-left-right-tablet' ).removeClass( 'active' );
			$( 'tr.widge-position-tablet' ).removeClass( 'active' );

			$( 'tr.position-top-bottom-mobile' ).addClass( 'active' );
			$( 'tr.position-left-right-mobile' ).addClass( 'active' );
			$( 'tr.widge-position-mobile' ).addClass( 'active' );
		} else {
			$( '.box-setting-option .box-device .boxes button.desktop' ).addClass( 'active' );

			$( 'tr.position-top-bottom' ).addClass( 'active' );
			$( 'tr.position-left-right' ).addClass( 'active' );
			$( 'tr.widge-position' ).addClass( 'active' );

			$( 'tr.position-top-bottom-tablet' ).removeClass( 'active' );
			$( 'tr.position-left-right-tablet' ).removeClass( 'active' );
			$( 'tr.widge-position-tablet' ).removeClass( 'active' );

			$( 'tr.position-top-bottom-mobile' ).removeClass( 'active' );
			$( 'tr.position-left-right-mobile' ).removeClass( 'active' );
			$( 'tr.widge-position-mobile' ).removeClass( 'active' );
		}
	} );

	// Additional event to set default image on page load
	// Get the 'src' attribute of the first icon image as the default
	const initialImage = $( 'tr.icons td .box-setting-option.icons .box-control .boxes .box label.checked' ).first().children().attr( 'src' );

	// If initialImage exists, set it as the default for 'size' and 'border' sections
	if ( initialImage ) {
		$( 'tr.size td .box-setting-option.size .box-control .boxes .box label img' ).attr( 'src', initialImage );
		$( 'tr.border td .box-setting-option.border .box-control .boxes .box label img' ).attr( 'src', initialImage );
	}

	// Attach a click event listener to all <a> tags with href starting with '#'
	$( 'a[href^="#"]' ).on( 'click', function( event ) {
		// Get the target element based on the href attribute of the clicked link
		const target = $( $.attr( this, 'href' ) );

		// Check if the target element exists
		if ( target.length ) {
			// Prevent the default anchor link behavior (default jump)
			event.preventDefault();

			// Set the offset for how far above the target the scroll should stop
			const offset = 110;

			// Animate scrolling to the target element minus the offset
			$( 'html, body' ).animate( {
				scrollTop: target.offset().top - offset,
			}, 0 ); // Duration of the scroll (0 means no animation)
		}
	} );

	const link = document.querySelectorAll(
		'.wrap .tabs .mycontainer .myrow .box-menu a'
	);
	const row = document.querySelectorAll( '.wrap .data-content' );

	link.forEach( function( item, index ) {
		link[ index ].addEventListener( 'click', function() {
			// Get id
			const getId = '.' + this.getAttribute( 'myid' );

			// Remove all class active link
			link.forEach( function( element ) {
				element.classList.remove( 'active' );
			} );

			// Active class link
			this.classList.add( 'active' );

			// Hide all data content
			row.forEach( function( element ) {
				element.classList.add( 'hide' );
				element.classList.remove( 'active' );
			} );

			// Show data content active current
			document
				.querySelector( getId + '.data-content' )
				.classList.remove( 'hide' );
			document
				.querySelector( getId + '.data-content' )
				.classList.add( 'active' );
		} );
	} );

	/**
	 * Copy content from a TinyMCE editor or textarea and give visual feedback.
	 *
	 * @param {string} editorId - The ID of the TinyMCE editor or textarea.
	 * @param {jQuery} $button  - The jQuery object for the copy button.
	 */
	$( '.copy' ).on( 'click', function() {
		const editorId = 'onetap_editor_generator';
		let content = '';

		// Try to get content from TinyMCE editor if available
		if ( typeof tinymce !== 'undefined' && tinymce.get( editorId ) ) {
			content = tinymce.get( editorId ).getContent();
		} else {
			// Fallback to plain textarea value if TinyMCE is not available
			content = $( '#' + editorId ).val();
		}

		const $button = $( this ); // The copy button element
		const $textElement = $button.find( '.copy-text' ); // The span that holds the button text
		const originalText = $button.data( 'default-text' ) || 'Copy'; // Default button text
		const copiedText = $button.data( 'copied-text' ) || 'Copied!'; // Text shown after copying

		// Copy the editor content to clipboard
		navigator.clipboard.writeText( content ).then( () => {
			// Update the button UI to show 'Copied!' and apply visual feedback
			$textElement.text( copiedText );
			$button.addClass( 'copied' );

			// Reset the button UI after 2 seconds
			setTimeout( () => {
				$textElement.text( originalText );
				$button.removeClass( 'copied' );
			}, 2000 );
		} );
	} );

	/**
	 * Initialize form validation and interactivity for the Accessibility Statement form.
	 *
	 * This function:
	 * - Caches relevant form elements.
	 * - Validates input fields and checkbox in real-time.
	 * - Enables or disables the submit button based on validation.
	 * - Prevents form submission if validation fails.
	 *
	 * Assumes the DOM is already loaded before this function is called.
	 */
	function handleAccessibilityStatusForm() {
		// Cache selectors to avoid querying the DOM repeatedly
		const $selectLanguage = $( 'select[name="onetap_select_language"]' );
		const $companyName = $( 'input[name="onetap_company_name"]' );
		const $companyWebsite = $( 'input[name="onetap_company_website"]' );
		const $businessEmail = $( 'input[name="onetap_business_email"]' );
		const $confirmationCheckbox = $( 'input[name="onetap_confirmation_checkbox"]' );
		const $submitButton = $( 'button.save-changes.generate-accessibility-statement' );

		// Function to check if all form fields are valid
		function checkFormFields() {
			const selectLanguage = ( $selectLanguage.val() || '' ).trim();
			const companyName = ( $companyName.val() || '' ).trim();
			const companyWebsite = ( $companyWebsite.val() || '' ).trim();
			const businessEmail = ( $businessEmail.val() || '' ).trim();
			const confirm = $confirmationCheckbox.is( ':checked' );

			// Enable or disable the submit button based on input validation
			if ( selectLanguage && companyName && companyWebsite && businessEmail && confirm ) {
				$submitButton.addClass( 'active' );
			} else {
				$submitButton.removeClass( 'active' );
			}
		}

		// Attach event listeners for inputs and checkbox
		$selectLanguage.on( 'input', checkFormFields );
		$companyName.on( 'input', checkFormFields );
		$companyWebsite.on( 'input', checkFormFields );
		$businessEmail.on( 'input', checkFormFields );
		$confirmationCheckbox.on( 'change', checkFormFields );

		// Initial check on page load
		checkFormFields();

		// Prevent form submission if fields are not valid
		$submitButton.on( 'click', function( e ) {
			const selectLanguage = ( $selectLanguage.val() || '' ).trim();
			const companyName = ( $companyName.val() || '' ).trim();
			const companyWebsite = ( $companyWebsite.val() || '' ).trim();
			const businessEmail = ( $businessEmail.val() || '' ).trim();
			const confirm = $confirmationCheckbox.is( ':checked' );

			// Validate that all required fields are filled before proceeding
			if ( ! selectLanguage || ! companyName || ! companyWebsite || ! businessEmail || ! confirm ) {
				e.preventDefault();
				// Show warning using SweetAlert
				swal( {
					title: 'Warning!',
					text: 'Please complete all fields.',
					icon: 'info',
					showCloseButton: true,
				} );
				return;
			}

			// Find the status message element that matches the selected language
			const $matchingStatusMessage = $( '.status-message-accessibility[data-content-lang="' + selectLanguage + '"]' );

			// Generate current date in localized format: [MonthName Day, Year]
			const now = new Date();
			const options = { year: 'numeric', month: 'long', day: 'numeric' };
			const locale = selectLanguage || 'en'; // fallback to 'en' if not selected
			const formattedDate = `${ now.toLocaleDateString( locale, options ) }`;

			// Get the HTML content of the matching status message
			let htmlContent = $matchingStatusMessage.html(); // Use html() to preserve HTML formatting

			// Replace placeholders in the HTML with actual values
			htmlContent = htmlContent.replace( /\[Company Name\]/g, companyName )
				.replace( /\[Company Website\]/g, companyWebsite )
				.replace( /\[Company E-Mail\]/g, businessEmail )
				.replace( /\[March 9, 2025\]/g, formattedDate );

			// Set the final content into the TinyMCE editor if it's initialized
			const editor = tinymce.get( 'onetap_editor_generator' );
			if ( editor ) {
				editor.setContent( htmlContent );
			}

			e.preventDefault();
		} );
	}
	handleAccessibilityStatusForm();
}( jQuery ) );
