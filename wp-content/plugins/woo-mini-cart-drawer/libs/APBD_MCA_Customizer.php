<?php
	/**
	 * @since: 09/10/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	
	class APBD_MCA_Customizer {
		
		public $core;
		function __construct() {
			$this->core=APBDWCM_settings::GetModuleInstance();
			add_action( 'customize_update_apbd_store', [$this->core,'CustomizerUpdate'], 10, 2 );
			add_action('customize_register',[$this,'RegisterCustomizer']);
			add_action( 'customize_preview_init', [$this, 'customizer_live_preview' ] );
			add_action( 'customize_controls_enqueue_scripts', [$this, 'customizer_control_handler' ] );
			$this->pluginFile=$this->core->pluginFile;
			$this->core->addTopMenu($this->core->__("Edit Using WP Customizer"),"fa fa-puzzle-piece",admin_url( '/customize.php?autofocus[panel]=apbd_mca_panel' ),"btn btn-success text-white",false,["target"=>"_blank"]);
		}
		function __($string, $parameter = NULL, $_ = NULL){
			$args = func_get_args();
			return call_user_func_array( [ $this->core, "__" ], $args );
		}
		function customizer_control_handler() {
			wp_enqueue_script( $this->core->GetModuleId() . "customizer_control", plugins_url( "js/customizer_control.js", $this->core->pluginFile ), array( 'jquery', 'customize-preview' ), time(), true );
		}
		function customizer_live_preview() {
			wp_enqueue_style( 'apbd-customizer-animation', plugins_url( "uilib/app-animation/app-animation.css", $this->core->pluginFile  ), [], time(), 'all' );
			
			wp_enqueue_script( $this->core->GetModuleId() . "CustomizerPreviewJS", plugins_url( "js/customizer.js", $this->core->pluginFile ), array( 'jquery', 'customize-preview' ), '', true );
			
			$itemQty   = WC()->cart->get_cart_contents_count();
			$items     = WC()->cart->get_cart_item_quantities();
			$totalItem = ! empty( $items ) ? count( $items ) : 0;
			wp_localize_script( $this->core->GetModuleId() . "CustomizerPreviewJS", 'apbd_customizer_mca_vars',
				[
					'skin'      => [
						'RE' => plugins_url( "css/skin-red.css", $this->core->pluginFile ) . "?t=" . filemtime(plugin_dir_path($this->core->pluginFile))."/css/skin-red.css",
						'GG' => plugins_url( "css/skin-green.css", $this->core->pluginFile ) . "?t=" . filemtime(plugin_dir_path($this->core->pluginFile))."/css/skin-green.css",
						'DB' => plugins_url( "css/skin-darkblue.css", $this->core->pluginFile ) . "?=t" . filemtime(plugin_dir_path($this->core->pluginFile))."/css/skin-darkblue.css",
						'PP' => plugins_url( "css/skin-pink.css", $this->core->pluginFile ) . "?t=" .  filemtime(plugin_dir_path($this->core->pluginFile))."/css/skin-pink.css",
						'DD' => plugins_url( "css/skin-dark.css", $this->core->pluginFile ) . "?t=" .  filemtime(plugin_dir_path($this->core->pluginFile))."/css/skin-dark.css",
						'LL' => plugins_url( "css/skin-light.css", $this->core->pluginFile ) . "?=t" .  filemtime(plugin_dir_path($this->core->pluginFile))."/css/skin-light.css",
						'BB' => plugins_url( "css/skin-blue.css", $this->core->pluginFile ) . "?=t" .  filemtime(plugin_dir_path($this->core->pluginFile))."/css/skin-blue.css"
					],
					'type'      => [
						'D' => plugins_url( "css/frontend.css", $this->core->pluginFile ) . "?t=" . filemtime(plugin_dir_path($this->core->pluginFile))."/css/frontend-floating",
						'F' => plugins_url( "css/frontend-floating.css", $this->core->pluginFile ) . "?t=" . filemtime(plugin_dir_path($this->core->pluginFile))."/css/frontend.css",
					],
					'wc_qty'    => $itemQty,
					'dr_footer' => [
						'TA' => WC()->cart->get_cart_subtotal(),
						'TQ' => $this->__( ( $itemQty > 1 ? "%d QTYS" : "%d QTY" ), $itemQty ),
						'TI' => $this->__( ( $totalItem > 1 ? "%d items" : "%d item" ), $totalItem ),
					]
				]
			);
			
			
		}
		
		/**
		 * @param WP_Customize_Manager $wp_customize
		 */
		function RegisterCustomizer($wp_customize){
			
			$wp_customize->add_panel( 'apbd_mca_panel', array(
				'title' => $this->core->mini_cart_customer_menu,
				'description' => "", // Include html tags such as <p>.
				//'priority' =>160 , // Mixed with top-level-section hierarchy.
			) );
			$wp_customize->add_section( 'apbd_mca_general' , array(
				'title' => $this->core->__("General Settings"),
				'panel' => 'apbd_mca_panel',
			) );
			
			$wp_customize->add_section( 'apbd_mca_drawer' , array(
				'title' => $this->core->__("Drawer Settings"),
				'panel' => 'apbd_mca_panel',
			) );
			
			$wp_customize->add_section( 'apbd_mca_cart_container' , array(
				'title' => $this->core->__("Cart Item Settings"),
				'panel' => 'apbd_mca_panel',
			));
			
			/*General Settings*/
			//drawer Position
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("drawer_type"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("drawer_type","D"),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Select_Control(
				$wp_customize, // WP_Customize_Manager
				$this->core->getCustomizerControlId("drawer_type"), // Setting id
				array( // Args, including any custom ones.
					'label' => $this->core->__( 'Drawer Type' ),
					'section' => 'apbd_mca_general',
					'description' => $this->core->__( 'Choose a mini cart type' ),
					'choices' => $this->core->getDrawerTypeOption(),
				)
			));
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("position"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("position","LM"),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Select_Control(
					$wp_customize, // WP_Customize_Manager
					$this->core->getCustomizerControlId("position"), // Setting id
					array( // Args, including any custom ones.
						'label' => $this->core->__( 'Position' ),
						'section' => 'apbd_mca_general',
						'choices' => [
							"LT"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/left-top.jpg', $this->core->pluginFile ) . '"/>'.$this->core->__('Left Top').'</div>',
							"LM"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/left-middle.jpg', $this->core->pluginFile ) . '"/>'.$this->core->__('Left Middle').'</div>',
							"LB"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/left-bottom.jpg', $this->core->pluginFile ) . '"/>'.$this->core->__('Left Bottom').'</div>',
							"RT"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/right-top.jpg', $this->core->pluginFile ) . '"/>'.$this->core->__('Right Top').'</div>',
							"RM"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/right-middle.jpg', $this->core->pluginFile ) . '"/>'.$this->core->__('Right Middle').'</div>',
							"RB"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/right-bottom.jpg', $this->core->pluginFile ) . '"/>'.$this->core->__('Right Bottom').'</div>',
						],
					)
				)
			);
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("control_size"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("control_size",60),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Slider_Control(
				$wp_customize, // WP_Customize_Manager
				$this->core->getCustomizerControlId("control_size"), // Setting id
				array( // Args, including any custom ones.
					'label' => $this->core->__( 'Size' ),
					'section' => 'apbd_mca_general',
					'description' => $this->core->__( 'Choose a size' ),
					'min'=>60,
					'max'=>100,
					'unit'=>'px'
				)
			));
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("border_radius"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("border_radius",10),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Slider_Control(
				$wp_customize, // WP_Customize_Manager
				$this->core->getCustomizerControlId("border_radius"), // Setting id
				array( // Args, including any custom ones.
					'label' => $this->core->__( 'Border Radius' ),
					'section' => 'apbd_mca_general',
					'description' => $this->core->__( 'Choose a border radius' ),
					'min'=>0,
					'max'=>50,
					'unit'=>'%'
				)
			));
			
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("top_margin"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("top_margin",10),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Slider_Control(
				$wp_customize, // WP_Customize_Manager
				$this->core->getCustomizerControlId("top_margin"), // Setting id
				array( // Args, including any custom ones.
					'label' => $this->core->__( 'Bottom Margin' ),
					'section' => 'apbd_mca_general',
					'description' => $this->core->__( 'Choose a Bottom margin' ),
					'min'=>0,
					'max'=>800,
					'unit'=>'px'
				)
			));
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("left_margin"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("left_margin",10),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Slider_Control(
				$wp_customize, // WP_Customize_Manager
				$this->core->getCustomizerControlId("left_margin"), // Setting id
				array( // Args, including any custom ones.
					'label' => $this->core->__( 'Left/Right Margin' ),
					'section' => 'apbd_mca_general',
					'description' => $this->core->__( 'Choose a left margin' ),
					'min'=>0,
					'max'=>800,
					'unit'=>'px'
				)
			));
			
		
			
			
			
			//Color Position
			$wp_customize->add_setting( $this->core->getCustomizerControlId("color"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("color","BB"),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Select_Control(
					$wp_customize, // WP_Customize_Manager
					$this->core->getCustomizerControlId("color"), // Setting id
					array( // Args, including any custom ones.
						'label' => $this->core->__( 'Color' ),
						'section' => 'apbd_mca_general',
						'description' => $this->core->__( 'Choose a color of mini cart' ),
						'choices' => [
							"BB"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/blue.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
							"DB"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/darkblue.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
							"GG"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/green.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
							"RE"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/red.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
							"PP"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/pink.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
							"LL"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/light.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
							"DD"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/dark.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
							//"DD"  => '<div class="apbd-rdo-container apbd-pro-btn"><img src="' . plugins_url( 'images/cartstyles/dark.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						],
					)
				)
			);
			
			
			
			
			
			$this->DrawerSettings($wp_customize);
			$this->ItemSettings($wp_customize);
			
			
		}
		function DrawerSettings(&$wp_customize){
			$wp_customize->add_setting( $this->core->getCustomizerControlId("icon"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("icon","ap-cart"),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$app_icon_option = [];
			$app_icon_option['ap-cart']='<i class="icon-ch-ad apmc ap-cart" ></i>';
			foreach (range(1,19) as $ici){
				$app_icon_option['ap-cart-'.$ici]='<i class="icon-ch-ad apmc ap-cart-'.$ici.'" ></i>';
			}
			$wp_customize->add_control( new APBD_Content_Select_Control(
					$wp_customize, // WP_Customize_Manager
					$this->core->getCustomizerControlId("icon"), // Setting id
					array( // Args, including any custom ones.
						'label' => $this->core->__( 'Icon' ),
						'section' => 'apbd_mca_drawer',
						'description' => $this->core->__( 'Choose an icon for mini cart' ),
						'choices' => $app_icon_option,
					)
				)
			);
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("df_type"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("df_type","TI"),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Select_Control(
					$wp_customize, // WP_Customize_Manager
					$this->core->getCustomizerControlId("df_type"),
					[   'label' => $this->core->__( 'Footer Content' ),
					    'section' => 'apbd_mca_drawer',
					    'description' => $this->core->__( 'Choose drawer footer' ),
					    'choices' => [
						    "TI"  => '<div class="apbd-rdo-container"><i class="dr-footer-type apmc ap-drawer"></i><div>'.$this->__('%s Items',2).'</div><div>'.$this->__('Total Items').'</div></div>',
						    "TQ"  => '<div class="apbd-rdo-container"><i class="dr-footer-type apmc ap-drawer"></i><div>'.$this->__('%s Qtys',3).'</div><div>'.$this->__('Total Quantities').'</div></div>',
						    "TA"  => '<div class="apbd-rdo-container"><i class="dr-footer-type apmc ap-drawer"></i><div>'.$this->__('$ 425.00').'</div><div>'.$this->__('Total Amount').'</div></div>',
					    ],
					]
				)
			);
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("dr_anim"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("dr_anim","ape-jello"),
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Select_Control(
					$wp_customize, // WP_Customize_Manager
					$this->core->getCustomizerControlId("dr_anim"),
					[   'label' => $this->core->__( 'Display Animation' ),
					    'section' => 'apbd_mca_drawer',
					    'description' => $this->core->__( 'Choose Display Animation' ),
					    'choices' => [
						    "ape-none"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-none"></i><div>&nbsp;</div><div>'.$this->__('None').'</div></div>',
						    "ape-jello"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-jello"></i><div>&nbsp;</div><div>'.$this->__('jello').'</div></div>',
						    "ape-pulse"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-pulse"></i><div>&nbsp;</div><div>'.$this->__('pulse').'</div></div>',
						    "ape-rubberBand"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-rubberBand"></i><div>&nbsp;</div><div>'.$this->__('rubberBand').'</div></div>',
						    "ape-bounce"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-bounce"></i><div>&nbsp;</div><div>'.$this->__('bounce').'</div></div>',
						    "ape-flash"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-flash"></i><div>&nbsp;</div><div>'.$this->__('flash').'</div></div>',
						
						    "ape-wobble"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-wobble"></i><div>&nbsp;</div><div>'.$this->__('wobble').'</div></div>',
						    "ape-flipInX"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-flipInX"></i><div>&nbsp;</div><div>'.$this->__('flipInX').'</div></div>',
						    "ape-fadeInLeft"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-fadeInLeft"></i><div>&nbsp;</div><div>'.$this->__('fadeInLeft').'</div></div>',
						    "ape-fadeInRight"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apmc ap-drawer pr-animated ape-fadeInRight"></i><div>&nbsp;</div><div>'.$this->__('fadeInRight').'</div></div>',
					
					    ],
					]
				)
			);
			
			$wp_customize->add_setting( $this->core->getCustomizerControlId("hide_corner_circle"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("hide_corner_circle","N")=="Y",
				'transport' => 'postMessage', // or postMessage
				'sanitize_callback' => '',
				'sanitize_js_callback' => '', // Basically to_json.
			) );
			$wp_customize->add_control( new APBD_Content_Switch_Control(
					$wp_customize, // WP_Customize_Manager
					$this->core->getCustomizerControlId("hide_corner_circle"),
					[   'label' => $this->core->__( 'Hide Corner Circle' ),
					    'section' => 'apbd_mca_drawer',
					    'description' => $this->core->__( 'if you enabled it, then circle counter of the top corner will be hide' ),
					]
				)
			);
			
		}
		function ItemSettings(&$wp_customize){
			//item container
			$wp_customize->add_setting( $this->core->getCustomizerControlId("title_text"), array(
				'type' => 'apbd_store', // or 'option'
				'capability' => 'edit_theme_options',
				'theme_supports' => '', // Rarely needed.
				'default' =>$this->core->GetOption("title_text","My Cart"),
				'transport' => 'postMessage' // or postMessage
			) );
			
			$wp_customize->add_control( $this->core->getCustomizerControlId("title_text"), array(
				'priority' => 11, // Within the section.
				'section' => 'apbd_mca_cart_container', // Required, core or custom.
				'label' => $this->core->__( 'Title Text' ),
				'description' => $this->core->__( 'Cart item title ' ),
				'type' => 'text'
			));
			
		}
	}