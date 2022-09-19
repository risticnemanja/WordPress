<?php
	/** @var APBDWCM_settings $this */
	$items= WC()->cart->get_cart_item_quantities();
	$totalItem=!empty($items)?count($items):0;
	$totalQty=WC()->cart->get_cart_contents_count();
	$undoProduct=APBD_session::GetSession("_cart_last_rm_item");
	$itemText=$totalItem>1?$this->__("Items"):$this->__("Item");
	$qtyText=$totalQty>1?$this->__("Quantities"):$this->__("Quantity");
	
	
	$icon=$this->GetOption("icon","ap-cart");  //ap-cart
	$df_type=$this->GetOption("df_type","TI");  //TA
	$dr_anim=$this->GetOption("dr_anim","ape-jello");  //ape-jello
	$hide_corner_circle=$this->GetOption("hide_corner_circle","N")=="Y";  //N
	$circle_type=$this->GetOption("circle_type","Q");  //Q
 
	$is_show_dis_total=$this->GetOption("is_show_dis_total","N")=="Y";  //Y
	$is_show_all_fee=$this->GetOption("is_show_all_fee","N")=="Y";  //N
	$is_cart_btn=$this->GetOption("is_cart_btn","Y")=="Y";  //Y
	$is_checkout_btn=$this->GetOption("is_checkout_btn","Y")=="Y";  //Y
	$title_text=$this->GetOption("title_text","My Cart");  //Cart
	$is_undo_remove=$this->GetOption("is_undo_remove","Y") =="Y";  //N
	$df_amount_type=$this->GetOption("df_amount_type","S");  //N
    
    $circle_qty=$circle_type=="Q"?$totalQty:$totalItem;
	
	$total    = WC()->cart->get_total( '' );
	$subtotal=WC()->cart->get_cart_contents_total() + WC()->cart->get_cart_contents_tax();
	WC()->cart->calculate_totals();
    //$cartTotal          = wc_prices_include_tax() ? WC()->cart->get_cart_contents_total() + WC()->cart->get_cart_contents_tax() : WC()->cart->get_cart_contents_total();
    $cartTotal = WC()->cart->get_subtotal() + WC()->cart->get_subtotal_tax();
	$drawerFooterContent="";
    switch ($df_type) {
        case 'TA':
		    $drawerFooterContent = $df_amount_type=="C"?WC()->cart->get_cart_total():wc_price($cartTotal);
		    break;
	    case 'TQ':
		    $drawerFooterContent = esc_html( $this->__( ( $totalQty > 1 ? "%d QTYS" : "%d QTY" ), $totalQty ) );
		    break;
	    case 'TI':
	    default:
		    $drawerFooterContent = esc_html( $this->__( ( $totalItem > 1 ? "%d items" : "%d item" ), $totalItem ) );
    }
   
 
?>
<div id="apbd-mini-cart-ajax" class="apbd-mini-cart-ajax apbd-mca-sshow" data-mcahash="<?php echo hash('crc32b',serialize($this->options)); ?>">
    <div class="apbd-mca-drawer-control <?php echo empty($is_first_laod)?' animated '.$dr_anim:''; ?>">
        <div class="apbd-mca-icon">
            <i class="apmc <?php echo esc_html($icon); ?>"></i>
            <?php if(!$hide_corner_circle){?>
            <span class="apbd-qty-c"><?php echo esc_html($circle_qty); ?></span>
            <?php } ?>
        </div>
        <div class="apbd-mca-cart-close">
            <span> <i class="apmc ap-angle-double-left   apf-horizontal animated  "></i> </span>
        </div>
        <div class="apbd-mca-item-counter <?php echo $df_type=='TA' && $cartTotal>100000?"c-sm-font":"" ?>">
            <?php echo $drawerFooterContent;?>
        </div>
       
    </div>
    <div class="apbd-mca-drawer-content">
        <?php if(empty($is_first_laod)){ ?>
        <div class="apbd-mca-cart-title">
            <i class=" apmc <?php echo $icon; ?>"></i>
            <span> <?php echo esc_html( $title_text );?></span>
            <?php echo ( $totalQty > 0 ? '<small> ' . esc_html( '(' . $this->__( "%d $itemText, %d $qtyText", $totalItem, $totalQty ) . ')' ) . '</small>' : "" ); ?>
            <div class="apbd-mca-loading">
                <i class="apmc ap-circle-o-notch apf-spin animated"></i>
            </div>
        </div>
	    <?php if($is_undo_remove && ! empty( $undoProduct )){ ?>
        <div class="apbd-mca-cart-undo">
            <div class="apbd-mca-undo-con">
                <div class="apbd-mca-p-msg"> <?php echo $undoProduct->item_image . '<span class="apbd-mca-ut">' . esc_html( $undoProduct->item_name ) . '</span>' . esc_html( $this->__( " - removed" ) ); ?></div>
                <div class="apbd-mca-p-btn">
                    <button data-key="<?php echo $undoProduct->cart_key; ?>"
                            class="apbd-undo apbd-btn apbd-btn-sm apbd-btn-info"><?php echo esc_html( $this->__( "Undo?", $undoProduct->item_name ) ); ?></button>
                    <button class="apbd-no-undo apbd-btn apbd-btn-sm apbd-btn-danger"><?php echo esc_html( $this->__( "No" ) ); ?></button>
                </div>

            </div>

        </div>
	    <?php } ?>
        <div class="apbd-mca-cart-items">
        <?php $items = WC()->cart->get_cart();
        if(count($items)>0){
        ?>
            <ul>
			    <?php
				    
				    foreach ( $items as $cart_item_key => $cart_item ) {
					    if ( ! isset( $cart_item['bundled_by'] ) && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						    $wc_product      = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						    $wc_product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						    $wc_product_link = apply_filters( 'woocommerce_cart_item_permalink', $wc_product->is_visible() ? $wc_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						    $item_thumbnail  = $wc_product->get_image();
						    $item_name       = $wc_product->get_name();
						    $product_link    = apply_filters( 'woocommerce_cart_item_permalink', $wc_product->is_visible() ? $wc_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						    ?>
                            <li data-key="<?php echo $cart_item_key; ?>"
                                class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'apbd-mca-cart-item', $cart_item, $cart_item_key ) ); ?>">
                                <div class="apbd-mca-i-rm"><i class="apmc ap-times-circle"></i></div>
                                <div class="apbd-mca-i-thumb">
								    <?php if ( ! empty( $product_link ) ) { ?>
                                        <a href="<?php echo $product_link; ?>"><?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $item_thumbnail, $cart_item, $cart_item_key ); ?></a>
								    <?php } else {
									    echo '<span>'.apply_filters( 'woocommerce_cart_item_thumbnail', $item_thumbnail, $cart_item, $cart_item_key )."</span>";
								    } ?>
                                </div>
                                <div class="apbd-mca-i-dtls">
                                    <div class="apbd-mca-i-dtls-title">
									
									    <?php if ( ! empty( $product_link ) ) { ?>
                                            <a href="<?php echo $product_link; ?>"><?php echo apply_filters( 'woocommerce_cart_item_name', $item_name, $cart_item, $cart_item_key );; ?></a>
									    <?php } else {
										    echo apply_filters( 'woocommerce_cart_item_name', $item_name, $cart_item, $cart_item_key );
									    } ?>
                                    </div>
                                    <div class="apbd-mca-i-dtls-ctrl">
                                        <div class="apbd-mca-i-price">
										    <?php
											    echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $wc_product ), $cart_item, $cart_item_key );
										    ?>
                                        </div>
                                        <div class="apbd-mca-i-ctrl">
		                                    <?php
			                                    $cart_item_quantity = $cart_item['quantity'];
			                                    if ( $wc_product->is_sold_individually() || ! empty( $cart_item['woosb_parent_id'] ) || ! empty( $cart_item['wooco_parent_id'] ) ) {
				                                    ?>
                                                    <span> </span><input class=""
                                                                         value="<?php echo esc_html( $cart_item['quantity'] ) ?>"
                                                                         type="number" disabled><span> </span>
				                                    <?php
			                                    } else {
				                                    if($this->isValidQuantity($cart_item['data'],$cart_item_quantity,$cart_item_quantity-1)) {
					                                    ?>
                                                        <span class="apbd-mca-qty-m apmc ap-minus-circle"></span>
				                                    <?php }else{
					                                    ?>
                                                        <span> </span>
					                                    <?php
				                                    } ?>
                                                    <input
                                                            class="mca-qry"
                                                            value="<?php echo esc_html( $cart_item['quantity'] ) ?>"
                                                            type="number">
				
				                                    <?php if($this->isValidQuantity($cart_item['data'],$cart_item_quantity,$cart_item_quantity+1)) { ?>
                                                        <span class="apbd-mca-qty-p apmc ap-plus-circle"></span>
					                                    <?php
				                                    }else{
					                                    ?>
                                                        <span> </span>
					                                    <?php
				                                    }
			                                    }
		                                    ?>
                                        </div>
                                        <div class="apbd-mca-i-total"><?php echo wc_price( $cart_item['line_subtotal']+$cart_item['line_subtotal_tax'] ) ?></div>
                                    </div>
                                </div>

                            </li>
						    <?php
					    }
				    }
			    ?>
            </ul>
            <?php }else{
            ?>
            <div class="v-align-m text-center"> <i class="apmc ap-cart-15"></i> <?php $this->_e("Empty Cart") ; ?></div>
            <?php
        } ?>
            <div class="apbd-loader-bg"></div>
        </div>
        <div class="apbd-mca-cart-footer">
            <ul>
                <li>
                    <div class="apbd-lbl"><?php $this->_e( "Sub Total" ); ?></div>
                    <div class="apbd-price"><?php echo wc_price($cartTotal); ?></div>
                </li>
			    <?php
				
				  
				    $insertedOtherEntry = false;
				    $discount_total     = WC()->cart->get_cart_discount_total()+WC()->cart->get_cart_discount_tax_total();
				    $shipping_total     = WC()->cart->get_shipping_total();
				    $fee_total          = WC()->cart->get_fee_total();
				    $taxes_total        = WC()->cart->get_taxes_total();
				    
				    if ( $is_show_dis_total ) {
					
					    if ( $discount_total > 0 ) {
						    ?>
                            <li>
                                <div class="apbd-lbl"><?php echo esc_html( $this->__( "Discount" ) ); ?></div>
                                <div class="apbd-price"><?php echo "-" . wc_price( $discount_total ); ?></div>
                            </li>
					    <?php }
                    if($subtotal!=$cartTotal) {
                        ?>
                        <li class="apbd-mca-total">
                            <div class="apbd-lbl"><?php echo $cartTotal != $total ? esc_html($this->__("Cart Total")) : esc_html($this->__("Total")); ?></div>
                            <div class="apbd-price"><?php echo WC()->cart->get_cart_total(); ?></div>
                        </li>
                        <?php
                    }
                        if($is_show_all_fee) {
	                        if ( $shipping_total > 0 ) { ?>
                                <li>
                                    <div class="apbd-lbl"><?php echo esc_html( $this->__( "Shipping" ) ); ?></div>
                                    <div class="apbd-price"><?php echo wc_price( $shipping_total ); ?></div>
                                </li>
	                        <?php }
	                        if ( $fee_total > 0 ) { ?>
                                <li>
                                    <div class="apbd-lbl"><?php echo esc_html( $this->__( "Total Fee" ) ); ?></div>
                                    <div class="apbd-price"><?php echo wc_price( $fee_total ); ?></div>
                                </li>
	                        <?php }
	                        if ( !wc_prices_include_tax() && $taxes_total > 0 ) { ?>
                                <li>
                                    <div class="apbd-lbl"><?php echo esc_html( $this->__( "Tax Total" ) ); ?></div>
                                    <div class="apbd-price"><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></div>
                                </li>
	                        <?php }
	                        if ( $insertedOtherEntry || $cartTotal != $total ) { ?>
                                <li class="apbd-mca-total">
                                    <div class="apbd-lbl"><?php echo esc_html( $this->__( "Total" ) ); ?></div>
                                    <div class="apbd-price"><?php echo apply_filters( 'woocommerce_cart_total', wc_price( $total ) ); ?></div>
                                </li>
	                        <?php }
                        }
				    }?>
            </ul>
	        
            <?php
		  if($is_cart_btn || $is_checkout_btn){ ?>
                <div class="apbd-mca-foot-bottom">
               
            <div class="apbd-row apbd-p-2 ">
                <div class="apbd-col ">
                    <?php if($is_cart_btn){ ?>
                        <a href="<?php echo wc_get_cart_url(); ?>" class="apbd-btn apbd-btn-theme"><i class="apmc ap-cart-menu"></i> <?php echo $this->GetOption("cart_btn_text",$this->__('View Full Cart')); ; ?></a>
                    <?php } ?>
                </div>
                <div class="apbd-col apbd-text-right">
	                <?php if($is_checkout_btn){ ?>
                        <a href="<?php echo wc_get_checkout_url(); ?>" class="apbd-btn apbd-btn-theme"><i class="apmc ap-cart"></i> <?php echo $this->GetOption("checkout_btn_text",$this->__('Checkout')); ; ?></a>
                    <?php } ?>
                </div>
            </div>
                </div>
            <?php } ?>
        </div>
        <?php }else{
            ?>
            <div class="mca-loading"></div>
            <?php
        } ?>
    </div>
</div>