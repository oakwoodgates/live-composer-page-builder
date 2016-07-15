<?php
/**
 * ROW settings/controls functions.
 *
 * Table of Contents
 *
 * - dslc_row_display_options ( Output ROW settings/controls. )
 * - dslc_row_get_options_fields ( Output hidden text input elements that will be used as data storage. )
 * - dslc_row_get_style ( Generate CSS styles for the ROW )
 * - dslc_row_get_initial_style ( Get initial ( default ) row style )
 *
 * @package LiveComposer
 */

/**
 * Output ROW settings/controls.
 */
function dslc_row_display_options() {

	// Global var containing options.
	global $dslc_var_row_options;

	// If empty return?
	if ( empty( $dslc_var_row_options ) ) {
		return;
	}

	foreach ( $dslc_var_row_options as $row_option ) {

		$css_rule_output = '';

		if ( isset( $row_option['affect_on_change_rule'] ) ) {

			$css_rule_output = $row_option['affect_on_change_rule'];
		}

		$css_element_output = '';
		if ( isset( $row_option['affect_on_change_el'] ) ) {

			$css_element_output = $row_option['affect_on_change_el'];
		}

		$extra_class = '';
		if ( 'image' === $row_option['type'] || 'video' === $row_option['type'] ) {

			$extra_class = 'dslca-modules-section-edit-option-upload';
		}

		if ( 'border_checkbox' === $row_option['type'] || 'checkbox' === $row_option['type'] ) {

			$extra_class = 'dslca-modules-section-edit-option-checkbox';
		}

		if ( ! isset( $row_option['ext'] ) ) {

			$row_option['ext'] = '';
		}

		if ( ! isset( $row_option['min'] ) ) {

			$row_option['min'] = 0;
		}

		if ( ! isset( $row_option['max'] ) ) {

			$row_option['max'] = 100;
		}

		if ( ! isset( $row_option['increment'] ) ) {

			$row_option['increment'] = 1;
		}

		?>
		<div class="dslca-modules-section-edit-option dslca-modules-section-edit-option-<?php echo $row_option['type']; ?> <?php echo esc_attr( $extra_class ); ?>" data-id="<?php echo esc_attr( $row_option['id'] ); ?>">

			<span class="dslca-modules-section-edit-label"><?php echo esc_html( $row_option['label'] ); ?></span>

			<?php if ( 'text' === $row_option['type'] ) : ?>

				<input type="text" class="dslca-modules-section-edit-field" data-id="<?php echo esc_attr( $row_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" />

			<?php elseif ( 'select' === $row_option['type'] ) : ?>

				<select type="text" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-select" data-id="<?php echo esc_attr( $row_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" >
					<?php foreach ( $row_option['choices'] as $choice ) : ?>
						<option value="<?php echo esc_attr( $choice['value'] ); ?>"><?php echo esc_attr( $choice['label'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<span class="dslca-icon dslc-icon-caret-down"></span>

			<?php elseif ( 'color' === $row_option['type'] ) : 

				$style = '';

				if ( isset( $curr_value ) && '' !== $curr_value ) {

					$text_color_value = $curr_value;

					if ( ! strpos( $curr_value, '#' ) ) {

						$text_color_value =dslc_rgbtohex( $text_color_value );
					}

					$color = dslc_get_contrast_bw( $text_color_value );

					$style = ' style="background: ' . $curr_value . '; color: ' . $color . '"';
				}?>

				<input type="text" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-colorpicker" data-id="<?php echo esc_attr( $row_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" />

			<?php elseif ( 'image' === $row_option['type'] ) : ?>

				<span class="dslca-modules-section-edit-field-image-add-hook"><span class="dslca-icon dslc-icon-cloud-upload"></span><?php esc_html_e( 'Upload Image', 'live-composer-page-builder' ); ?></span>
				<span class="dslca-modules-section-edit-field-image-remove-hook"><span class="dslca-icon dslc-icon-remove"></span><?php esc_html_e( 'Remove Image', 'live-composer-page-builder' ); ?></span>
				<input type="hidden" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-upload" data-id="<?php echo esc_attr( $row_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" />

			<?php elseif ( 'video' === $row_option['type'] ) : ?>

				<span class="dslca-modules-section-edit-field-image-add-hook"><span class="dslca-icon dslc-icon-cloud-upload"></span><?php esc_html_e( 'Upload Video', 'live-composer-page-builder' ); ?></span>
				<span class="dslca-modules-section-edit-field-image-remove-hook"><span class="dslca-icon dslc-icon-remove"></span><?php esc_html_e( 'Remove Video', 'live-composer-page-builder' ); ?></span>
				<input type="hidden" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-upload" data-id="<?php echo esc_attr( $row_option['id'] ); ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" />

			<?php elseif ( 'slider' === $row_option['type'] ) : ?>

					<?php
						$slider_min = $row_option['min'];
						$slider_max = $row_option['max'];
						$slider_increment = $row_option['increment'];
						$ext = $row_option['ext'];
						$curr_value = $row_option['std'];

					?>

					<input type="number" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-slider-numeric" data-id="<?php echo esc_attr( $row_option['id'] ); ?>" value="<?php echo $curr_value; ?>" data-css-element="<?php echo esc_attr( $css_element_output ); ?>" data-css-rule="<?php echo esc_attr( $css_rule_output ); ?>" data-min="<?php echo $slider_min; ?>" data-max="<?php echo $slider_max; ?>" data-ext="<?php echo $ext; ?>" data-increment="<?php echo esc_attr( $row_option['increment'] ); ?>" data-ext="<?php echo esc_attr( $row_option['ext'] ); ?>"/>

			<?php elseif ( 'border_checkbox' === $row_option['type'] ) : ?>

				<div class="dslca-modules-section-edit-option-checkbox-wrapper">
					<div class="dslca-modules-section-edit-option-checkbox-single">
						<span class="dslca-modules-section-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Top', 'live-composer-page-builder' ); ?></span>
						<input type="checkbox" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-checkbox" data-id="border-top" data-css-rule="border-width">
					</div>
					<div class="dslca-modules-section-edit-option-checkbox-single">
						<span class="dslca-modules-section-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Right', 'live-composer-page-builder' ); ?></span>
						<input type="checkbox" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-checkbox" data-id="border-right" data-css-rule="border-width">
					</div>
					<div class="dslca-modules-section-edit-option-checkbox-single">
						<span class="dslca-modules-section-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Bottom', 'live-composer-page-builder' ); ?></span>
						<input type="checkbox" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-checkbox" data-id="border-bottom" data-css-rule="border-width">
					</div>
					<div class="dslca-modules-section-edit-option-checkbox-single">
						<span class="dslca-modules-section-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php esc_html_e( 'Left', 'live-composer-page-builder' ); ?></span>
						<input type="checkbox" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-checkbox" data-id="border-left" data-css-rule="border-width">
					</div>
				</div>

			<?php elseif ( 'checkbox' === $row_option['type'] ) : ?>

				<div class="dslca-modules-section-edit-option-checkbox-wrapper">
					<?php foreach ( $row_option['choices'] as $choices ) : ?>
						<div class="dslca-modules-section-edit-option-checkbox-single">
							<span class="dslca-modules-section-edit-option-checkbox-hook"><span class="dslca-icon dslc-icon-check-empty"></span><?php echo esc_attr( $choices['label'] ); ?></span>
							<input type="checkbox" class="dslca-modules-section-edit-field dslca-modules-section-edit-field-checkbox" data-val="<?php echo esc_attr( $choices['value'] ); ?>" data-id="<?php echo esc_attr( $row_option['id'] ); ?>">
						</div>
					<?php endforeach; ?>
				</div>

			<?php endif; ?>

		</div><!-- .dslca-modules-section-edit-option -->
		<?php
	}
}

/**
 * Output hidden text input elements that will be used as data storage.
 *
 * @param  array $atts   Array with data to fill in.
 * @return string        String with HTML code.
 */
function dslc_row_get_options_fields( $atts = false ) {

	$output = '';

	// Global var containing options.
	global $dslc_var_row_options;

	// If empty return.
	if ( empty( $dslc_var_row_options ) ) {

		return;
	}

	// Go through each option and append HTML.
	if ( $atts ) { // If there is data to fill?

		foreach ( $dslc_var_row_options as $row_option ) {

			// Don't move this line! 'dslca-img-url' should go before 'bg_image'.
			if ( isset( $atts[ $row_option['id'] ] ) && 'bg_image' === $row_option['id'] ) {

				$output .= '<input type="text" data-id="dslca-img-url" value="' . wp_get_attachment_url( $atts[ $row_option['id'] ] ) . '" data-def="' . wp_get_attachment_url( $atts[ $row_option['id'] ] ) . '">';
			}

			if ( isset( $atts[ $row_option['id'] ] ) ) {

				$output .= '<input type="text" data-id="' . $row_option['id'] . '" value="' . $atts[ $row_option['id'] ] . '" data-def="' . $atts[ $row_option['id'] ] . '">';
			} else {

				$output .= '<input type="text" data-id="' . $row_option['id'] . '" value="' . $row_option['std'] . '" data-def="' . $row_option['std'] . '">';
			}
		}
	} else { // If it's a new ROW?

		foreach ( $dslc_var_row_options as $row_option ) {

			if ( ! isset( $row_option['std'] ) ) {

				$row_option['std'] = '';
			}

			// Don't move this line! 'dslca-img-url' should go before 'bg_image'.
			if ( isset( $row_option['id'] ) && 'bg_image' === $row_option['id'] ) {

				$output .= '<input type="text" data-id="dslca-img-url" value="' . wp_get_attachment_url( $row_option['std'] ) . '" data-def="' . wp_get_attachment_url( $row_option['std'] ) . '">';
			}

			$output .= '<input type="text" data-id="' . $row_option['id'] . '" value="' . $row_option['std'] . '">';
		}
	}

	return $output;

}

/**
 * Generate CSS styles for the ROW
 *
 * @param  array $atts set of section attributes.
 * @return string      CSS styles for the ROW.
 */
function dslc_row_get_style( $atts = false ) {

	global $dslc_var_row_options;
	$style = '';

	// If empty return?
	if ( empty( $dslc_var_row_options ) ) {

		return;
	}

	// Loop through all options.
	foreach ( $dslc_var_row_options as $row_option ) {

		// If there's an el then it's not for the section div?
		if ( ! isset( $row_option['affect_on_change_el'] ) ) {

			// The CSS rules.
			$rules = false;
			if ( isset( $row_option['affect_on_change_rule'] ) ) {

				$rules = explode( ',', $row_option['affect_on_change_rule'] );
			}

			// The CSS value.
			$value = false;
			if ( $atts && isset( $atts[ $row_option['id'] ] ) ) {

				$value = $atts[ $row_option['id'] ];
			} elseif ( isset( $row_option['std'] ) ) {

				$value = $row_option['std'];
			}

			$orig_value = $value;

			// The CSS value extension.
			if ( isset( $row_option['ext'] ) ) {

				$value = $value . $row_option['ext'];
			}

			// Border.
			if ( 'border' === $row_option['id'] ) {

				$checkbox_arr = explode( ' ', trim( $value ) );

				if ( ! in_array( 'top', $checkbox_arr, true ) ) {

					$style .= 'border-top-style: hidden; ';
				}

				if ( ! in_array( 'right', $checkbox_arr, true ) ) {

					$style .= 'border-right-style: hidden; ';
				}

				if ( ! in_array( 'bottom', $checkbox_arr, true ) ) {

					$style .= 'border-bottom-style: hidden; ';
				}

				if ( ! in_array( 'left', $checkbox_arr, true ) ) {

					$style .= 'border-left-style: hidden; ';
				}
			}

			if ( $value && $rules ) {

				foreach ( $rules as $rule ) {

					if ( 'background-image' === $rule ) {

						if ( 'bg_image_thumb' === $row_option['id'] ) {

							if ( 'enabled' === $value ) {

								$value = 'url(' . apply_filters( 'dslc_row_bg_featured_image', wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ) . ')';
							}
						} else {

							$value = 'url(' . wp_get_attachment_url( $value ) . ')';
						}
					}

					if ( ! isset( $row_option['std'] ) || $orig_value !== $row_option['std'] ) {

						$style .= $rule . ':' . $value . ';';
					}
				}
			}
		}
	}

	return $style;
}

/**
 * Get initial ( default ) row style
 *
 * @since 1.0
 */
function dslc_row_get_initial_style() {

	global $dslc_var_row_options;
	$style = '';

	// If empty return.
	if ( empty( $dslc_var_row_options ) ) {
		return;
	}

	// Loop through all options.
	foreach ( $dslc_var_row_options as $row_option ) {

		// If there's an el then it's not for the section div.
		if ( ! isset( $row_option['affect_on_change_el'] ) ) {

			// The CSS rules.
			$rules = false;
			if ( isset( $row_option['affect_on_change_rule'] ) ) {

				$rules = explode( ',', $row_option['affect_on_change_rule'] );
			}

			// The CSS value.
			$value = false;
			if ( isset( $row_option['std'] ) ) {
				$value = $row_option['std'];
			}

			$orig_value = $value;

			// The CSS value extension.
			if ( isset( $row_option['ext'] ) ) {

				$value = $value . $row_option['ext'];
			}

			// Border.
			if ( 'border' === $row_option['id'] ) {

				$checkbox_arr = explode( ' ', trim( $value ) );

				if ( ! in_array( 'top', $checkbox_arr, true ) ) {

					$style .= 'border-top-style: hidden; ';
				}

				if ( ! in_array( 'right', $checkbox_arr, true ) ) {

					$style .= 'border-right-style: hidden; ';
				}

				if ( ! in_array( 'bottom', $checkbox_arr, true ) ) {

					$style .= 'border-bottom-style: hidden; ';
				}

				if ( ! in_array( 'left', $checkbox_arr, true ) ) {

					$style .= 'border-left-style: hidden; ';
				}
			}

			if ( $value && $rules ) {

				foreach ( $rules as $rule ) {

					if ( 'background-image' === $rule ) {

						if ( 'bg_image_thumb' === $row_option['id'] ) {

							if ( 'enabled' === $value ) {

								$value = 'url(' . wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) . ')';
							}
						} else {

							$value = 'url(' . wp_get_attachment_url( $value ) . ')';
						}
					}

					$style .= $rule . ':' . $value . ';';

				}
			}
		}
	}

	return '.dslc-modules-section { ' . $style . ' }';
}
