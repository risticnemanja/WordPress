<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	/**
	 * @property APBDWC_currency_item   $active_currency
	 */
	class APBDWCM_settings extends AppsBDLiteModule{
		private $temp_code=null;
		public $active_currency;
		public $mini_cart_customer_menu;
		public static $_wp_localise=[];
		public $newAddedItem=false;
		function initialize() {
			parent::initialize();
			$this->mini_cart_customer_menu=$this->__("Mini Cart Ajax");
			$this->disableDefaultForm();
			$this->AddAjaxAction("update-qty",[$this,"update_qty"]);
			$this->AddAjaxNoPrivAction("update-qty",[$this,"update_qty"]);
			
			$this->AddAjaxAction("remove-item",[$this,"remove_cart_item"]);
			$this->AddAjaxNoPrivAction("remove-item",[$this,"remove_cart_item"]);
			
			$this->AddAjaxAction("undo-remove",[$this,"undo_remove"]);
			$this->AddAjaxNoPrivAction("undo-remove",[$this,"undo_remove"]);
			
			$this->AddAjaxAction("no-undo",[$this,"no_remove"]);
			$this->AddAjaxNoPrivAction("no-undo",[$this,"no_remove"]);
			
			
			add_action( 'woocommerce_remove_cart_item', [$this,'on_cart_remove'], 10, 2 );
			add_action( 'woocommerce_cart_item_restored', [$this,'on_cart_restored'], 10, 2 );
			add_action( 'woocommerce_add_to_cart', [$this,'on_added_item'], 10, 6 );
			APBD_session::Start();
			add_action( 'wp_footer', [$this, 'wpFooter' ]);
			
			add_action($this->getHookActionStr("app-footer"),[$this,"admin_app_footer"]);
			new APBD_MCA_Customizer();
			if($this->GetOption("_rated","N")=="Y") {
			    $activated=$this->GetOption("_activated",null);
			    if(empty($activated)){
			        $this->AddOption("_activated",time());
                }else{
			        if(strtotime("+7 DAYS",$activated)<time()){
				        APBDAjaxMiniCart::GetInstance()->AddAdminNoticePlain( $this->rate_notice() );
                    }
                }
				
			}
			$this->AddAjaxAction("rated",[$this,"rated"]);
		}
		function OnInit() {
			parent::OnInit();
			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'cartFragment'] );
			//setcookie("apbd-mc-nonce",wp_create_nonce( 'apbd_mc_nonce' ),0,"/");
			
		}
		public function OnActive() {
			parent::OnActive();
		}
		public function AdminStyles() {
			parent::OnAdminGlobalStyles();
			
		}
	    public static function AddLocalizeVariable($name,$value){
		    self::$_wp_localise[$name]=$value;
        }
        public static function AddLocalizeVariables(array $vars)
        {
            foreach ($vars as $key=>$var){
                self::$_wp_localise[$key]=$var;
            }
        }
		
		/**
		 * @param $value
		 * @param WP_Customize_Setting $setting
		 */
		public function CustomizerUpdate($value, $setting){
		    $option_name=$this->getCustomizerControlIdToRealId($setting->id);
		    $boolOptions=['hide_corner_circle'];
		    if(in_array($option_name,$boolOptions)) {
			    $value = empty( $value ) ? "N" : "Y";
		    }
		    $this->AddOption($option_name,$value);
        }
		public function GetCustomizerData($ID,$default=null){
			$option_name=$this->getCustomizerControlIdToRealId($ID);
			return $this->GetOption($option_name,$default);
		}
		function AdminScripts()
        {
            wp_localize_script( 'apd-main-js', 'apbd_mca_admin_vars',
               self::$_wp_localise
            );
        }
        function getInlineCss(){
		    $width=$this->GetOption("control_size",80);
		    $left_or_right=$this->GetOption("left_margin",0);
	        $isLeftPosition=in_array($this->GetOption("position","LM"),['LM','LT','LB']);
	        
	        $isMidilePosition=in_array($this->GetOption("position","LM"),['LM','RM']);
	        $isTopPosition=in_array($this->GetOption("position","LM"),['LT','RT']);
	        $isBottomPosition=in_array($this->GetOption("position","LM"),['LB','RB']);
	        
	        $topMargin=$this->GetOption("top_margin",0);
	        
	        $borderRadius=$this->GetOption("border_radius",50);
	        
		        ?>
            <style id="apbd-woo-mini-cart-frontend-inline-css" type="text/css">
                #apbd-mini-cart-container.apbd-floating-type:not(.apbd-mca-show) .apbd-mini-cart-ajax .apbd-mca-drawer-control {
                    position: fixed !important;
                    width: <?php echo $width; ?>px !important;
                    height: <?php echo $width; ?>px !important;
                    <?php if($isLeftPosition){ ?>
                    left: <?php echo $left_or_right; ?>px !important;
                    right: unset !important;
                    <?php }else{ ?>
                    right:<?php echo $left_or_right; ?>px !important;
                    left: unset !important;
                    <?php }
                    if($borderRadius>=0){?>
                    -webkit-border-radius: <?php echo $borderRadius; ?>%;
                    -moz-border-radius: <?php echo $borderRadius; ?>%;
                    border-radius: <?php echo $borderRadius; ?>%;
                    bottom: <?php echo $topMargin; ?>px !important;
                   <?php }?>
                }
            </style>
		        <?php
	       
        }
		function getInlineBlankCss(){
			?>
            <style id="apbd-woo-mini-cart-frontend-inline-css" type="text/css">
            
            </style>
			<?php
			
		}
        function ClientStyle() {
	        if($this->GetOption("drawer_type","D")=="F"){
		        $this->AddClientStyle("apbd-woo-mini-cart-frontend","frontend-floating.css");
		        wp_add_inline_style( 'apbd-woo-mini-cart-frontend', $this->getInlineCss());
            }else{
		        $this->AddClientStyle("apbd-woo-mini-cart-frontend","frontend.css");
		        wp_add_inline_style( 'apbd-woo-mini-cart-frontend',  $this->getInlineBlankCss());
            }
			
			$color=$this->GetOption("color","BB");
			switch ($color){
                case 'RE':
	                $this->AddClientStyle("apbd-woo-mini-cart-skin-red","skin-red.css");
                    break;
                case 'GG':
	                $this->AddClientStyle("apbd-woo-mini-cart-skin-green","skin-green.css");
                    break;
				case 'DB': //dark blue
					$this->AddClientStyle("apbd-woo-mini-cart-skin-darkblue","skin-darkblue.css");
					break;
                case 'PP':
				    $this->AddClientStyle("apbd-woo-mini-cart-skin-pink","skin-pink.css");
				    break;
                case 'DD':
	                $this->AddClientStyle("apbd-woo-mini-cart-skin-dark","skin-dark.css");
                    break;
                case 'LL':
	                $this->AddClientStyle("apbd-woo-mini-cart-skin-light","skin-light.css");
                    break;
				case 'BB':
                default:
				$this->AddClientStyle("apbd-woo-mini-cart-skin-blue","skin-blue.css");
            }
		}
		function getChangeHash() {
			return hash( 'crc32b', serialize( $this->options ) );;
		}
		function ClientScript() {
			
			$this->AddClientScript( "jquery-nicescroll", "uilib/nicescroll/jquery.nicescroll.min.js", true, [ 'jquery' ] );
			$this->AddClientScript( "apbd-woo-mini-cart-frontend-js", "frontend.min.js", false, [
				'jquery',
				'jquery-nicescroll'
			] );
			
			wp_localize_script( 'apbd-woo-mini-cart-frontend-js', 'apbd_mca_vars',
				array(
					'ajaxurl'        => admin_url( 'admin-ajax.php' ),
					'is_need_reload' => $this->GetOption( "is_reload_cart", "N" ),
					'nonce'          => wp_create_nonce( 'apbd_mc_nonce' ),
					'mcahash'        => $this->getChangeHash(),
					'slug'           => $this->pluginBaseName,//str_replace( "-", "_", $this->pluginBaseName ),
					'is_show_on_add' => $this->GetOption( "show_icontainer_on_each_item","N" ),
					'no_coupon_code' => $this->__( "Please enter the coupon code to apply" )
				)
			);
		}
		function GetMenuSubTitle() {
			return $this->__("Mini cart settings");
		}
		
		function GetMenuIcon() {
			return 'apmc ap-cart-container';
		}
		
		function getDrawerTypeOption(){
			return  [
				// "D"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/blue.jpg', $this->pluginFile ) . '"/>'.$this->__('Drawer').'</div>',
				// "F"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/blue.jpg', $this->pluginFile ) . '"/>'.$this->__('Floating').'</div>',
				"D"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apd-no-change apmc ap-drawer"></i><div>&nbsp;</div><div>'.$this->__('Drawer').'</div></div>',
				"F"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="dr-footer-anim apd-no-change apmc ap-circle"></i><div>&nbsp;</div><div>'.$this->__('Floating').'</div></div>',
			];
        }
		function GetMenuTitle() {
			return $this->__("Mini Cart");
		}
		function SettingsPage() {
		 
			$this->Display();
		}
		
		// start form here*/
		function verify_nonce(){
			$nonce=APBD_PostValue("security");
			if ( wp_verify_nonce( $nonce, 'apbd_mc_nonce' ) ) {
			    return true;
			}
			
			return true;
			$response=new AppsbdAjaxConfirmResponse();
			$response->DisplayWithResponse(false,$this->__("Nonce verify failed"));
			return false;
        }
		function on_cart_remove( $cart_item_key, $cart ) {
			$cart_item=$cart->cart_contents[ $cart_item_key ];
		    $wc_product      = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		    $session_object=new stdClass();
		    $session_object->cart_key=$cart_item_key;
		    $session_object->item_name=$wc_product->get_name();
		    $session_object->item_image=$wc_product->get_image();
			APBD_session::SetSession("_cart_last_rm_item",$session_object);
			
			
		}
		function on_cart_restored( $cart_item_key, $cart ) {
			APBD_session::UnsetSession("_cart_last_rm_item");
		}
		
		/**
		 * @param mixed ...$args
		 */
		function on_added_item( ...$args) {
			APBD_session::UnsetSession( "_cart_last_rm_item" );
			if(true | $this->GetOption( "show_icontainer_on_each_item","N" )=="Y") {
				$this->newAddedItem = true;
			}
		}
		function no_remove( ) {
			$this->verify_nonce();
			APBD_session::UnsetSession( "_cart_last_rm_item" );
			$response=new AppsbdAjaxConfirmResponse();
			$response->DisplayWithResponse(true,$this->__("done"));
		}
		
		function update_qty(){
			$this->verify_nonce();
			$itemId=APBD_PostValue("item_id",null);
			$qty=APBD_PostValue("qty",null);
			$response=new AppsbdAjaxConfirmResponse();
			if ( $itemId && $qty ) {
				$item=WC()->cart->get_cart_item($itemId);
				$errorMessate="";
				$qty=(int) $qty;
				$qty = apply_filters( 'woocommerce_add_to_cart_quantity', $qty, $itemId );
				if(isset($item['product_id']) && isset($item['product_id']) && isset($item['quantity']) ) {
					if ( $this->isValidQuantity( $item['data'], $item['quantity'], $qty, $errorMessate ) ) {
						if ( WC()->cart->set_quantity( $itemId, (int) $qty ) ) {
							$response->DisplayWithResponse( true, $this->__( "Successfully updated" ) ,$item['quantity']);
						} else {
							$response->DisplayWithResponse( false, $this->__( "Cart item update failed" ) ,$item['quantity']);
						}
					} else {
						$response->DisplayWithResponse( false, $errorMessate,$item['quantity'] );
					}
				}else{
					$response->DisplayWithResponse( false, "Cart item info not found-344",$item['quantity'] );
				}
				die;
				
			}else{
				$response->DisplayWithResponse(false,$this->__("ID & Qty both are required"));
			}
			$response->DisplayWithResponse(false,$this->__("Unknown error"));
			die;
		}
		function isValidQuantityById($product_id,$variation_id,$currentQty,$newQty,&$msg=""){
			$product_id   = absint( $product_id );
			$variation_id = absint( $variation_id );
			// Ensure we don't add a variation to the cart directly by variation ID.
			if ( 'product_variation' === get_post_type( $product_id ) ) {
				$variation_id = $product_id;
				$product_id   = wp_get_post_parent_id( $variation_id );
			}
			$product_data = wc_get_product( $variation_id ? $variation_id : $product_id );
			return $this->isValidQuantity($product_data,$currentQty,$newQty);
		}
		
		/**
		 * @param WC_Product $product_data
		 * @param $currentQty
		 * @param $newQty
		 * @param string $msg
		 *
		 * @return bool
		 */
		function isValidQuantity($product_data,$currentQty,$newQty,&$msg=""){
			try {
				
				if ( $newQty <= 0 || ! $product_data || 'trash' === $product_data->get_status() ) {
					return false;
				}
				
				// Force quantity to 1 if sold individually and check for existing item in cart.
				if ( $product_data->is_sold_individually() ) {
					if($newQty>1){
						$msg=sprintf( __( 'You cannot add another "%s" to your cart.', 'woocommerce' ), $product_data->get_name() );
						return false;
					}
				}
				
				if ( ! $product_data->is_purchasable() ) {
					$msg = $this->__( "Product is not purchasable" );
					return false;
				}
				
				// Stock check - only check if we're managing stock and backorders are not allowed.
				if ( ! $product_data->has_enough_stock( $newQty ) ) {
					/* translators: 1: product name 2: quantity in stock */
					$msg = sprintf( __( 'You cannot add that amount of &quot;%1$s&quot; to the cart because there is not enough stock (%2$s remaining).', 'woocommerce' ), $product_data->get_name(), wc_format_stock_quantity_for_display( $product_data->get_stock_quantity(), $product_data ) ) ;
					return false;
				}
				$msg = $this->__( "Unknown error-393" );
				return true;
				
			} catch ( Exception $e ) {
				
				return false;
			}
		}
		
		function rated() {
			$iRated   = APBD_GetValue("arated", "N" );
			$this->AddOption("_rated",$iRated);
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				$response = new AppsbdAjaxConfirmResponse();
				$response->DisplayWithResponse( $iRated == "Y", "Updated", $iRated );
			}else{
			    wp_safe_redirect(admin_url('index.php'));
			    die;
            }
		}
        function remove_cart_item() {
	        $this->verify_nonce();
	        $itemId   = APBD_PostValue( "item_id", NULL );
	        $response = new AppsbdAjaxConfirmResponse();
	        if ( $itemId) {
		        if ( WC()->cart->remove_cart_item( $itemId ) ) {
			        $response->DisplayWithResponse( true, $this->__( "Successfully removed" ) );
		        } else {
			        $response->DisplayWithResponse( false, $this->__( "Cart item remove failed" ) );
		        }
	        } else {
		        $response->DisplayWithResponse( false, $this->__( "ID & Qty both are required" ) );
	        }
	        $response->DisplayWithResponse( false, $this->__( "Unknown error" ) );
	        die;
        }
		function undo_remove() {
			$this->verify_nonce();
			$itemId   = APBD_PostValue( "item_id", NULL );
			$response = new AppsbdAjaxConfirmResponse();
			if ( $itemId) {
				if ( WC()->cart->restore_cart_item( $itemId ) ) {
					$response->DisplayWithResponse( true, $this->__( "Successfully removed" ) );
				} else {
					$response->DisplayWithResponse( false, $this->__( "Cart item remove failed" ) );
				}
			} else {
				$response->DisplayWithResponse( false, $this->__( "ID & Qty both are required" ) );
			}
			$response->DisplayWithResponse( false, $this->__( "Unknown error" ) );
			die;
		}
  
		function cartFragment($fragments){
			$fragments['.apbd-mini-cart-ajax'] = $this->LoadView("apbdwcm_settings/mini-cart",true);
			return $fragments;
		}
		function getPosition(){
		   $position="";
		   $positionOption=$this->GetOption("position","LM");
		   switch ($positionOption){
               case 'LT':
	               $position='apbd-mini-cart-top';
	               break;
               case 'LM':
	               $position='';
	               break;
			   case 'LB':
				   $position='apbd-mini-cart-bottom';
				   break;
			   case 'RT':
				   $position='apbd-mini-cart-right apbd-mini-cart-top';
				   break;
			   case 'RM':
				   $position='apbd-mini-cart-right ';
				   break;
			   case 'RB':
				   $position='apbd-mini-cart-right apbd-mini-cart-bottom';
				   break;
           }
			if($this->GetOption("drawer_type","D")=="F"){
				$position .= ' apbd-floating-type ';
			}
           return $position;
		    
        }
		function wpFooter(){
			if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			    return;
			}
			if($this->newAddedItem){
				$this->AddViewData("is_first_laod",true);
            }else{
				$this->AddViewData("is_first_laod",false);
            }
		    
		    //apbd-mini-cart-right
            // apbd-mini-cart-top , apbd-mini-cart-bottom
			?>
   
			<div id="apbd-mini-cart-container" class="<?php echo $this->getPosition().($this->newAddedItem?" apbd-mca-show ":""); ?>">
               
                <div id="apbd-mini-cart-ajax" data-noload="Y" class="apbd-mini-cart-ajax apbd-mca-sshow">
                <?php
	                $this->LoadView( 'apbdwcm_settings/mini-cart' );
                ?>
                </div>
			</div>
			<?php
		}
		
		function admin_app_footer(){
		    $this->Display("app-footer");
        }
		function rate_notice(){
			ob_start()
			?>
            <div class="notice apbd-notice-st1">
                <div class="apbd-notice-title" style="min-width:100px; max-width:150px;width: 20%">
                    <i class="abp abp-mca-logo"></i> Mini Cart Drawer
                </div>
                <div class=""  style="width: 60%">
                    <?php $this->_e("Are you enjoying it? Would you like to add a 5 start rate in WordPress.org?") ; ?>
                    <a class="apbd-nt-btn ml-3" target="_blank" href="https://wordpress.org/support/plugin/woo-mini-cart-drawer/reviews/?filter=5/#new-post" ><?php $this->_e("Yes Rate") ; ?> &#9733;&#9733;&#9733;&#9733;&#9733;</a>
                    <a class="apbd-nt-btn btn-success ml-3" id="mini-cart-review" href="<?php echo $this->GetActionUrl("rated",["arated"=>"Y"]);?>" > <?php $this->_e("I have already rated") ; ?></a>
                </div>
                <div class="" style="width: 20%">
                
                </div>
            </div>
			<?php
			return ob_get_clean();
		}
	}