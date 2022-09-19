<?php
	if ( ! function_exists("APBD_get_help_button")) {
		function APBD_get_help_button( $target_elem, $placement = 'top', $trigger = 'hover' ,$isReturn=false) {
			ob_start();
		    ?>
			<i class="apbd-help fa fa-info-circle app-popover apf-pulse animated-hover "
			   data-trigger="<?php echo $trigger; ?>" data-placement="<?php echo $placement; ?>"
			   data-element="<?php echo $target_elem; ?>"></i>
			<?php
            if($isReturn){
                return ob_get_clean();
            }
            echo ob_get_clean();
		}
	}