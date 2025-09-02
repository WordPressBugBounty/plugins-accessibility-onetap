/* eslint no-undef: "off", no-alert: "off" */
( function( $ ) {
	/**
	 * Handle save changes button click in header
	 * When the save changes button in the header is clicked,
	 * it triggers the actual submit button in the corresponding page form
	 */
	$( '.box-save-changes .save-changes' ).on( 'click', function( e ) {
		e.preventDefault();

		// Get current page parameter from URL
		const urlParams = new URLSearchParams( window.location.search );
		let currentPageId = urlParams.get( 'page' );

		// Convert hyphens to underscores for CSS ID selector compatibility
		currentPageId = currentPageId.replace( /-/g, '_' );

		// If contains "accessibility_onetap", remove only the "accessibility_" part
		if ( currentPageId.includes( 'accessibility_onetap' ) ) {
			currentPageId = currentPageId.replace( 'accessibility_', '' );
		}

		// Trigger click on the submit button within the current page form
		$( '#' + currentPageId + ' .submit-button .button' ).trigger( 'click' );
	} );

	// Handle radio image selection - remove checked class from all labels in the same group and add to clicked one
	$( '.setting-control.radio-image .box .label' ).click( function() {
		$( this ).closest( '.setting-control' ).find( '.label' ).removeClass( 'checked' );
		$( this ).addClass( 'checked' );
	} );

	// Handle radio text selection - remove checked class from all labels in the same group and add to clicked one
	$( '.setting-control.radio-text .box .label' ).click( function() {
		$( this ).closest( '.setting-control' ).find( '.label' ).removeClass( 'checked' );
		$( this ).addClass( 'checked' );
	} );

	// Initialize WordPress color picker for all color picker fields
	$( '.color-picker-field' ).wpColorPicker( {
		change( event, ui ) {
			const color = ui.color.toString();
			const $boxes = $( this ).closest( '.boxes' );

			// Update background color of .box1
			$boxes.find( '.box1' ).css( '--outline-color', color );

			// TODO: This code will be removed in future updates - preview functionality will be handled differently
			$( '.setting-control.color .boxes .box1 .wp-picker-container button.wp-color-result' ).css( 'outline-color', color );

			// TODO: This code will be removed in future updates - preview functionality will be handled differently
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				'background-color': color,
			} );

			// TODO: This code will be removed in future updates - preview functionality will be handled differently
			$( '.setting-control.radio-image .boxes .box label img' ).css( {
				'background-color': color,
			} );

			// TODO: This code will be removed in future updates - preview functionality will be handled differently
			$( '.settings-group.border .setting-control.radio-image .boxes .box1 label img' ).css( {
				border: 'solid 2px #fff',
				'box-shadow': '0 0 0 4px ' + color,
			} );

			// TODO: This code will be removed in future updates - preview functionality will be handled differently
			if ( 'design-border1' === $( '.settings-group.border .boxes .box input[type="radio"]:checked' ).val() ) {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					border: 'solid 2px #fff',
					'box-shadow': '0 0 0 4px ' + color,
				} );

				$( '.settings-group.border .setting-control.radio-image .boxes .box1 label img' ).css( {
					// border: 'solid 2px #fff',
					'box-shadow': '0 0 0 4px ' + color,
				} );
			} else if ( 'design-border2' === $( '.settings-group.border .boxes .box input[type="radio"]:checked' ).val() ) {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					border: 'none',
					'box-shadow': 'none',
				} );

				$( '.setting-control.radio-image .boxes .box2 label img' ).css( {
					// border: 'solid 2px transparent',
					'box-shadow': '0 0 0 4px transparent',
				} );
			}
		},
	} );

	// Open color picker when clicking on color result display
	$( document ).on( 'click', '.color-result', function() {
		$( this ).closest( '.boxes' ).find( '.color-picker-field' ).wpColorPicker( 'open' );
	} );

	// Handle color selection from predefined color list
	$( document ).on( 'click', '.boxes .box3 li', function() {
		const color = $( this ).data( 'color' );
		const $boxes = $( this ).closest( '.boxes' );

		// Set the selected color to the color picker field
		$boxes.find( '.color-picker-field' ).wpColorPicker( 'color', color );

		// Update the color result display text
		$boxes.find( '.color-result' ).text( color );

		// Update the outline color
		$boxes.find( '.box1 .wp-color-result' ).css( 'outline-color', color );
	} );

	/**
	 * Handle device button clicks for device-specific settings visibility
	 * This function manages the switching between desktop, tablet, and mobile device controls
	 * by updating button states and showing/hiding corresponding settings groups
	 */
	$( document ).on( 'click', '.devices-tabs button', function() {
		const $clickedButton = $( this );
		const selectedDevice = $clickedButton.attr( 'data-device-type' );
		const $allDeviceButtons = $( '.devices-tabs button' );

		// Validate device value
		if ( ! selectedDevice || ! [ 'desktop', 'tablet', 'mobile' ].includes( selectedDevice ) ) {
			console.warn( 'Invalid device type:', selectedDevice );
			return;
		}

		// Reset all device buttons to inactive state
		$allDeviceButtons.attr( 'aria-pressed', false ).removeClass( 'active' );

		// Set active state for the clicked button
		$clickedButton.attr( 'aria-pressed', true ).addClass( 'active' );

		// Remove active class from all preview-viewport elements
		$( '.preview-viewport' ).removeClass( 'active' );

		// Add active class to the corresponding preview element based on device type
		$( '.preview-' + selectedDevice ).addClass( 'active' );
		// Add active class to the corresponding viewport element based on device type
		$( '.viewport-' + selectedDevice ).addClass( 'active' );
	} );

	/**
	 * Inisialisasi semua slider-number pair yang ada di dalam .boxes
	 * Menghindari konflik antar elemen dengan melakukan binding berdasarkan konteks masing-masing .box
	 */
	function initNumberSliders() {
		$( '.setting-control.number-slider' ).each( function() {
			const $box = $( this );
			const $range = $box.find( 'input[type="range"]' );
			const $number = $box.find( 'input[type="number"]' );

			function updateSliderBackground( val, isHover = false ) {
				const min = parseFloat( $range.attr( 'min' ) );
				const max = parseFloat( $range.attr( 'max' ) );
				const value = parseFloat( val );
				const percentage = ( ( value - min ) / ( max - min ) ) * 100;

				// Warna default & hover
				const inactiveColor = isHover ? '#d5d7da' : '#E9EAEB';

				$range.css(
					'background',
					`linear-gradient(to right, #0048FE ${ percentage }%, ${ inactiveColor } ${ percentage }%)`
				);
			}

			// Initialize background on load
			updateSliderBackground( $range.val() );

			// Sync: range -> number
			$range.on( 'input', function() {
				const val = $( this ).val();
				$number.val( val );
				updateSliderBackground( val );
			} );

			// Sync: number -> range
			$number.on( 'input', function() {
				let val = parseFloat( $( this ).val() );
				const min = parseFloat( $range.attr( 'min' ) );
				const max = parseFloat( $range.attr( 'max' ) );

				val = Math.min( Math.max( val, min ), max );
				$range.val( val );
				updateSliderBackground( val );
			} );

			// Hover effect (range or number input)
			$range.add( $number ).hover(
				function() {
					updateSliderBackground( $range.val(), true ); // on hover
				},
				function() {
					updateSliderBackground( $range.val(), false ); // out hover
				}
			);
		} );
	}

	// Initialize number slider
	initNumberSliders();

	/**
	 * Handle copy button click for text copy functionality
	 * When the copy button is clicked, it copies the text from data attribute or adjacent .copy-text element
	 */
	$( document ).on( 'click', '.copy-button', function() {
		const $copyButton = $( this );

		// Get text to copy from data attribute first, then fallback to adjacent element
		let textToCopy = $copyButton.data( 'copy-text' );

		if ( ! textToCopy ) {
			const $copyText = $copyButton.prev( '.copy-text' );
			if ( $copyText.length ) {
				textToCopy = $copyText.text().trim();
			}
		}

		if ( textToCopy ) {
			// Use modern clipboard API if available
			if ( navigator.clipboard && window.isSecureContext ) {
				navigator.clipboard.writeText( textToCopy ).then( function() {
					// Show success feedback
					showCopyFeedback( $copyButton, true );
				} ).catch( function( err ) {
					console.error( 'Failed to copy text: ', err );
					// Fallback to old method
					fallbackCopyText( textToCopy, $copyButton );
				} );
			} else {
				// Fallback for older browsers or non-secure contexts
				fallbackCopyText( textToCopy, $copyButton );
			}
		}
	} );

	/**
	 * Fallback method for copying text using document.execCommand
	 * Used when modern clipboard API is not available
	 *
	 * @param {string} text    - The text to copy to clipboard
	 * @param {jQuery} $button - The copy button element
	 */
	function fallbackCopyText( text, $button ) {
		// Create temporary textarea element
		const textarea = document.createElement( 'textarea' );
		textarea.value = text;
		textarea.style.position = 'fixed';
		textarea.style.opacity = '0';
		document.body.appendChild( textarea );

		// Select and copy text
		textarea.select();
		const successful = document.execCommand( 'copy' );

		// Remove temporary element
		document.body.removeChild( textarea );

		// Show feedback
		showCopyFeedback( $button, successful );
	}

	/**
	 * Show visual feedback for copy operation
	 *
	 * @param {jQuery}  $button - The copy button element
	 * @param {boolean} success - Whether the copy operation was successful
	 */
	function showCopyFeedback( $button, success ) {
		const originalHTML = $button.html();

		if ( success ) {
			// Change button text to "Copied!" temporarily
			$button.text( 'Copied!' ).addClass( 'copied' );

			// Reset after 2 seconds
			setTimeout( function() {
				$button.html( originalHTML ).removeClass( 'copied' );
			}, 2000 );
		} else {
			// Show error feedback
			$button.text( 'Failed!' ).addClass( 'error' );

			// Reset after 2 seconds
			setTimeout( function() {
				$button.html( originalHTML ).removeClass( 'error' );
			}, 2000 );
		}
	}

	$( '.setting-manager-meida-browse' ).on( 'click', function( event ) {
		event.preventDefault();

		const self = $( this );

		// Create the media frame.
		const fileFrame = wp.media.frames.fileFrame = wp.media( {
			title: self.data( 'uploader_title' ),
			button: {
				text: self.data( 'uploader_button_text' ),
			},
			multiple: false,
		} );

		fileFrame.on( 'select', function() {
			attachment = fileFrame.state().get( 'selection' ).first().toJSON();
			self.prev( '.setting-manager-url' ).val( attachment.url ).change();
		} );

		// Finally, open the modal.
		fileFrame.open();
	} );
}( jQuery ) );
