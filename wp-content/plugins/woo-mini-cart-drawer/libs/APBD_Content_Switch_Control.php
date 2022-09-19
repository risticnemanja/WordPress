<?php
	/**
	 * @since: 09/10/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */

	class APBD_Content_Switch_Control extends WP_Customize_Control {
		
		public $type = 'apbd_switch';
		/**
		 * Render the control's content.
		 */
		public function enqueue() {
			wp_enqueue_style( 'apbd-customizer-matarial-css', plugins_url("../uilib/material/material.css",__FILE__) ,[], time(), 'all' );
			wp_enqueue_style( 'apbd-customizer-custom-controls-css', plugins_url("../css/customizer_control.css",__FILE__) ,[], time(), 'all' );
		}
		public function render_content() {
			$input_id         = '_customize-input-' . $this->id;
			$description_id   = '_customize-description-' . $this->id;
			$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
			?>
			<div class="wp-customizer-container">
                <div class="apbd-switch">
	                <?php if ( ! empty( $this->label ) ) : ?>
                        <label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
	                <?php endif; ?>
                    <div class="apbd-sw-control">
                        <div class="material-switch material-switch-sm">
                            <input  class=""
                                    id="<?php echo esc_attr( $input_id ); ?>"
                                <?php echo $describedby_attr; ?>
                                    type="checkbox"
                                    value="<?php echo esc_attr( $this->value() ); ?>"
                                <?php $this->link(); ?>
                                <?php checked( $this->value() ); ?>
                            >
                            <label for="<?php echo esc_attr( $input_id ); ?>" class="bg-mat"></label>
                        </div>
                    </div>
	              
                </div>
				<?php if ( ! empty( $this->description ) ) : ?>
                    <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
            </div>
			<?php
		}
	}