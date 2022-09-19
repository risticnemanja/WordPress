<?php
	/**
	 * @since: 09/10/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */

	class APBD_Content_Select_Control extends WP_Customize_Control {
		
		public $type = 'apbd_content_select';
		/**
		 * Render the control's content.
		 */
		public function enqueue() {
			wp_enqueue_style( 'apbd-customizer-custom-controls-css', plugins_url("../css/customizer_control.css",__FILE__) ,[], time(), 'all' );
		}
		public function render_content() {
			$input_id         = '_customize-input-' . $this->id;
			$description_id   = '_customize-description-' . $this->id;
			$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
			
			if ( empty( $this->choices ) ) {
				return;
			}
			
			$name = '_customize-radio-' . $this->id;
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<div class="apbd-app-box-radio">
			<?php foreach ( $this->choices as $value => $label ){?>
				<label class="apbd-app-box-option">
					<input class="apbd-app-box-option-input"
						id="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"
						type="radio"
						<?php echo $describedby_attr; ?>
						value="<?php echo esc_attr( $value ); ?>"
						name="<?php echo esc_attr( $name ); ?>"
						<?php $this->link(); ?>
						<?php checked( $this->value(), $value ); ?>
					/>
					<span class="apbd-app-box-html">
                         <?php echo $label;?>
                    </span>
				
				</label>
			<?php } ?>
			</div>
			<?php
		}
	}