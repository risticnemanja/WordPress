<?php
	/**
	 * @since: 09/10/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */

	class APBD_Content_Slider_Control extends WP_Customize_Control {
		public $type = 'range';
		
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );
			$defaults = array(
				'min'  => 0,
				'max'  => 10,
				'step' => 1,
				'unit' => ''
			);
			$args     = wp_parse_args( $args, $defaults );
			
			$this->min  = $args['min'];
			$this->max  = $args['max'];
			$this->step = $args['step'];
			$this->unit = $args['unit'];
		}
		
		public function render_content() {
			?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <div class="app-slider-input">
                <input <?php $this->link(); ?> type="range" name="border_radius" min="<?php echo $this->min; ?>" step="<?php echo $this->step; ?>" max="<?php echo $this->max; ?>" data-unit="<?php echo $this->unit; ?>" value="<?php echo esc_attr( $this->value() ); ?>">
            </div>
			<?php
		}
	}
	