<?php /** @var APBDWCM_settings $this */
//echo $this->GetActionUrl("get-rate");
?>
<div class="row">
    <div class="col">
        <?php
	        if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		        ?>
                <div class="alert alert-danger mt-3" role="alert">
                  <i class="fa fa-exclamation-triangle animated apf-flash"></i> <?php $this->_e(" Please install and activate WooCommerce to use %s plugin requires",'<strong>'.$this->kernelObject->pluginName.'</strong>') ; ?>
                </div>
		        <?php
	        }
        ?>
    <form class="apbd-module-form"  role="form" id="<?php echo $this->GetMainFormId();?>" action="<?php echo $this->GetActionUrl(""); ?>" method="post" <?php echo $this->isMultipartForm()?' enctype="multipart/form-data" ':''; ?>>
        <div class="card apsbd-default-card mt-3">
            <div class="card-header"><i class="ap ap-setting" style="font-size: 20px;vertical-align: -2px;"></i> <?php $this->_e("General Settings") ; ?></div>
            <div class="card-body p-3">
                <div class="form-group row">
                    <label for="drawer_type" class="col-xl-2 col-form-label "><?php $this->_e("Type") ?></label>
                    <div class="col-xl">
                        <div class="">
				            <?php
					            $app_chat_pattern_selected= $this->GetOption("drawer_type","D");
					            $app_wg_pos_option =$this->getDrawerTypeOption();
					            APBD_GetHTMLRadioBoxByArray("drawer_type","drawer_type","drawer_type",true,$app_wg_pos_option,$app_chat_pattern_selected,false,'','has_depend_fld bg-green',"test-cl",[]);
					            //APBD_GetHTMLRadioBoxByArray("Color","color","color",true,$app_wg_pos_option,$app_chat_pattern_selected,false,'','bg-green',"test-cl",['DD']);
				            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="new_license_hook" class="col-xl-2 col-form-label "><?php $this->_e("Position") ?></label>
                    <div class="col-xl">
                        <div class="">
				            <?php
					            $app_chat_pattern_selected= $this->GetOption("position","LM");
					            $app_wg_pos_option = [
						            "LT"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/left-top.jpg', $this->pluginFile ) . '"/>'.$this->__('Left Top').'</div>',
						            "LM"  => '<div class="apbd-rdo-container "><img src="' . plugins_url( 'images/positions/left-middle.jpg', $this->pluginFile ) . '"/>'.$this->__('Left Middle').'</div>',
						            "LB"  => '<div class="apbd-rdo-container "><img src="' . plugins_url( 'images/positions/left-bottom.jpg', $this->pluginFile ) . '"/>'.$this->__('Left Bottom').'</div>',
						            "RT"  => '<div class="apbd-rdo-container "><img src="' . plugins_url( 'images/positions/right-top.jpg', $this->pluginFile ) . '"/>'.$this->__('Right Top').'</div>',
						            "RM"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/positions/right-middle.jpg', $this->pluginFile ) . '"/>'.$this->__('Right Middle').'</div>',
						            "RB"  => '<div class="apbd-rdo-container "><img src="' . plugins_url( 'images/positions/right-bottom.jpg', $this->pluginFile ) . '"/>'.$this->__('Right Bottom').'</div>',
					            ];
					            APBD_GetHTMLRadioBoxByArray("Position","position","position",true,$app_wg_pos_option,$app_chat_pattern_selected,false,'','has_depend_fld bg-green');
				            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="new_license_hook" class="col-xl-2 col-form-label "><?php $this->_e("Color") ?></label>
                    <div class="col-xl">
                        <div class="">
				            <?php
					            $app_chat_pattern_selected= $this->GetOption("color","BB");
					            $app_wg_pos_option = [
						            "BB"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/blue.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						            "DB"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/darkblue.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						            "GG"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/green.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						            "RE"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/red.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						            "PP"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/pink.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						            "LL"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/light.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						            "DD"  => '<div class="apbd-rdo-container"><img src="' . plugins_url( 'images/cartstyles/dark.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
						            //"DD"  => '<div class="apbd-rdo-container apbd-pro-btn"><img src="' . plugins_url( 'images/cartstyles/dark.jpg', $this->pluginFile ) . '"/>'.$this->__('Skin').'</div>',
					            ];
					            APBD_GetHTMLRadioBoxByArray("Color","color","color",true,$app_wg_pos_option,$app_chat_pattern_selected,false,'','bg-green',"test-cl",[]);
					            //APBD_GetHTMLRadioBoxByArray("Color","color","color",true,$app_wg_pos_option,$app_chat_pattern_selected,false,'','bg-green',"test-cl",['DD']);
				            ?>
                        </div>
                    </div>
                </div>
                <div class="fld-drawer-type fld-drawer-type-f">
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group row mb-3">
                                <label for="control_size" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			                        <?php $this->_e("Size");?>
                                </label>
                                <div class="col-xl">
                                    <div class="app-slider-input">
                                        <input type="range" name="control_size" min="50" max="100" data-format="apd_value_format" data-unit="px"  value="<?php echo $this->GetOption("control_size",80); ?>">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="border_radius" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			                        <?php $this->_e("Border Radius");?>
                                </label>
                                <div class="col-xl">
                                    <div class="app-slider-input">
                                        <input type="range" name="border_radius" min="0" data-format="apd_value_format" data-unit="%" max="50" value="<?php echo $this->GetOption("border_radius",50); ?>">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="top_margin" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			                        <?php $this->_e("Bottom Margin");?>
                                </label>
                                <div class="col-xl">
                                    <div class="app-slider-input">
                                        <input type="range" name="top_margin" min="0" data-format="apd_value_format" data-unit="px" max="800" value="<?php echo $this->GetOption("top_margin",0); ?>">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row mb-3 ">
                                <label for="left_margin" class="col-xl-3 col-form-label pt-0 pr-sm-0 fld-position fld-position-lt fld-position fld-position-lm fld-position fld-position-lb">
			                        <?php $this->_e("Left Margin");?>
                                </label>
                                <label for="left_margin" class="col-xl-3 col-form-label pt-0 pr-sm-0 fld-position fld-position-rt fld-position fld-position-rm fld-position fld-position-rb">
			                        <?php $this->_e("Right Margin");?>
                                </label>
                                <div class="col-xl">
                                    <div class="app-slider-input">
                                        <input type="range" name="left_margin" min="0" data-format="apd_value_format" data-unit="px" max="800" value="<?php echo $this->GetOption("left_margin",0); ?>">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 d-none d-sm-block">
                            <div class="card">
                                <div class="card-body p-3 text-center">
                                    <?php $this->_e("You can easily configure this using wp customizer, Click the button bellow to customize") ; ?>
                                    <br/>
                                    <a href="<?php echo admin_url( 'customize.php?autofocus[panel]=apbd_mca_panel&autofocus[section]=apbd_mca_general') ?>" class="btn btn-success mt-3" ><?php $this->_e("Open WP Customizer") ; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <hr>
                <div class="form-group row mb-3">
                    <label for="hide_in_cart" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			            <?php $this->_e("Hide in cart page");?>
                    </label>
                    <div class="col-xl inline-switch">
                        <div class="material-switch material-switch-sm inline mt-0">
                            <button  class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                        </div>
                        <small class="form-text text-muted d-inline mt-0">
	                        <?php $this->_e("if you enabled it, the mini cart doesn't show in cart page") ; ?>
                        </small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="hide_in_checkout" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			            <?php $this->_e("Hide in checkout page");?>
                    </label>
                    <div class="col-xl inline-switch">
                        <div class="material-switch material-switch-sm inline mt-0">
                            <button  class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                        </div>
                        <small class="form-text text-muted d-inline mt-0">
	                        <?php $this->_e("if you enabled it, the mini cart doesn't show in checkout page") ; ?>
                        </small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="hide_on_other" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			            <?php $this->_e("Hide On Pages");?>
                    </label>
                    <div class="col-xl inline-switch">
                        <div class="material-switch material-switch-sm inline mt-0">
                            <button  class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                        </div>
                        <small class="form-text text-muted d-inline mt-0">
				            <?php $this->_e("You can choose page where you want to hide the cart button") ; ?>
                        </small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="hide_in_checkout" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			            <?php $this->_e("Don't show when cart empty");?>
                    </label>
                    <div class="col-xl inline-switch">
                        <div class="material-switch material-switch-sm inline mt-0">
                            <button  class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                        </div>
                        <small class="form-text text-muted d-inline mt-0">
				            <?php $this->_e("if you enabled it, the mini cart doesn't show when the cart is empty") ; ?>
                        </small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="show_icontainer_on_each_item" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			            <?php $this->_e("Cart Content show on each item add");?>
                    </label>
                    <div class="col-xl inline-switch">
	                    <?php
		                    APBD_GetHTMLSwitchButtonInline("show_icontainer_on_each_item","show_icontainer_on_each_item","N","Y",$this->GetOption("show_icontainer_on_each_item",'N'));
	                    ?>
                        <small class="form-text text-muted d-inline mt-0">
				            <?php $this->_e("if you enabled it, the mini cart item container will display on each cart add") ; ?>
                        </small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			            <?php $this->_e("Custom CSS");?>
                    </label>
                    <div class="col-xl inline-switch">
                        <div class="material-switch material-switch-sm inline mt-0">
                            <button  class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                        </div>
                        <small class="form-text text-muted d-inline mt-0">
				            <?php $this->_e("Click the button to add custom css") ; ?>
                        </small>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="add_menu_item" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			            <?php $this->_e("Add Menu Item");?>
                    </label>
                    <div class="col-xl inline-switch">
                        <div class="material-switch material-switch-sm inline mt-0">
                            <button  class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                        </div>
                        <small class="form-text text-muted d-inline mt-0">
				            <?php $this->_e("if you enabled it, it will show in menu item") ; ?>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success"><?php $this->_e("Save") ; ?></button>
            </div>
        </div>
    </form>
    </div>
</div>
<div class="row mb-3">
    <div class="col-xl pr-sm-0">
        <form class="apbd-module-form"  role="form" id="<?php echo $this->GetMainFormId();?>" action="<?php echo $this->GetActionUrl(""); ?>" method="post" <?php echo $this->isMultipartForm()?' enctype="multipart/form-data" ':''; ?>>
            <div class="card apsbd-default-card mt-3">
                <div class="card-header"><i class="apmc ap-drawer" style="font-size: 20px;vertical-align: -2px;"></i> <?php $this->_e("Cart Button or Drawer") ; ?></div>
                <div class="card-body p-3">
                    <div class="form-group row">
                        <label for="new_license_hook" class="col-xl-3 col-form-label " ><?php $this->_e("Icon") ?> <i class="apbd-help fa fa-info-circle app-popover apf-pulse animated-hover " data-trigger="hover" data-placement="top" data-element="#icon-popover"></i></label>
                        <div class="col-xl">
                            <div class="">
		                        <?php
			                        $app_icon_selected= $this->GetOption("icon","ap-cart");
			                        $app_icon_option = [];
			                        $app_icon_option['ap-cart']='<i class="icon-ch-ad apmc ap-cart" ></i>';
			                        foreach (range(1,19) as $ici){
				                        $app_icon_option['ap-cart-'.$ici]='<i class="icon-ch-ad apmc ap-cart-'.$ici.'" ></i>';
				                       
                                   }
			                        APBD_GetHTMLRadioBoxByArray("Icon","icon","icon",true,$app_icon_option,$app_icon_selected,false,'','bg-green',null,['DD']);
		                        ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="fld-drawer-type fld-drawer-type-d">
                        <div class="form-group row">
                            <label for="new_license_hook" class="col-xl-3 col-form-label " ><?php $this->_e("Footer Content");
					                APBD_get_help_button("#drawer-type-popover");
				                ?>
                            </label>
                            <div class="col-xl">
                                <div class="">
					                <?php
						                $df_type= $this->GetOption("df_type","TI");
						                $df_type_option = [
							                "TI"  => '<div class="apbd-rdo-container"><i class="dr-footer-type apmc ap-drawer"></i><div>'.$this->__('%s Items',2).'</div><div>'.$this->__('Total Items').'</div></div>',
							                "TQ"  => '<div class="apbd-rdo-container"><i class="dr-footer-type apmc ap-drawer"></i><div>'.$this->__('%s Qtys',3).'</div><div>'.$this->__('Total Quantities').'</div></div>',
							                "TA"  => '<div class="apbd-rdo-container"><i class="dr-footer-type apmc ap-drawer"></i><div>'.$this->__('$ 425.00').'</div><div>'.$this->__('Total Amount').'</div></div>',
						                ];
						                APBD_GetHTMLRadioBoxByArray("df_type","df_type","df_type",true,$df_type_option,$df_type,false,'','has_depend_fld',null);
					                ?>
                                </div>
                            </div>
                        </div>

                        <div class="fld-df-type fld-df-type-ta">
                            <hr>
                            <div class="form-group row">
                                <label for="df_amount_type" class="col-xl-3 col-form-label pt-0 pr-sm-0">
					                <?php $this->_e("Amount Type");
						                APBD_get_help_button("#type-circle");
					                ?>
                                </label>
                                <div class="col-xl ">
                                    <div class="">
						
						                <?php
							                APBD_GetHTMLRadioByArray("df_amount_type","df_amount_type","df_amount_type",true,["S"=>$this->__("Sub Total"),"C"=>'<span class="app-popover " data-trigger="hover" data-placement="top" data-content="'.$this->__("Sub Total - Discount = Cart Total").'">'.$this->__("Cart Total").'</span>'],$this->GetOption("df_amount_type","S"),false,true,"");
							                //APBD_GetHTMLSwitchButton("has_support","has_support","N","Y",$mainobj->GetPostValue("has_support"),false,"has_depend_fld2"); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="form-group row">
                        <label for="dr_anim" class="col-xl-3 col-form-label pr-sm-0">
                            <?php $this->_e("Display Animation");
	                            APBD_get_help_button("#drawer-animation");
                            ?>
                            
                        </label>
                        <div class="col-xl">
                            <div class="">
                                <?php
	                                $anim_selected= $this->GetOption("dr_anim","ape-jello");
	
	                                $anim_options = [
		                                "ape-none"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-none"></i><i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-none"></i><div>&nbsp;</div><div>'.$this->__('None').'</div></div>',
		                                "ape-jello"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-jello"></i> <i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-jello"></i><div>&nbsp;</div><div>'.$this->__('jello').'</div></div>',
		                                "ape-pulse"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-pulse"></i> <i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-pulse"></i> <div>&nbsp;</div><div>'.$this->__('pulse').'</div></div>',
		                                "ape-rubberBand"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-rubberBand"></i> <i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-rubberBand"></i><div>&nbsp;</div><div>'.$this->__('rubberBand').'</div></div>',
		                                "ape-bounce"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-bounce"></i> <i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-bounce"></i><div>&nbsp;</div><div>'.$this->__('bounce').'</div></div>',
		                                "ape-flash"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-flash"></i> <i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-flash"></i><div>&nbsp;</div><div>'.$this->__('flash').'</div></div>',
		                                "ape-wobble"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-wobble"></i><i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-wobble"></i><div>&nbsp;</div><div>'.$this->__('wobble').'</div></div>',
		                                "ape-flipInX"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-flipInX"></i><i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-flipInX"></i><div>&nbsp;</div><div>'.$this->__('flipInX').'</div></div>',
		                                "ape-fadeInLeft"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-fadeInLeft"></i><i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-fadeInLeft"></i><div>&nbsp;</div><div>'.$this->__('fadeInLeft').'</div></div>',
		                                "ape-fadeInRight"  => '<div class="apbd-rdo-container ape-animated-pr-hover"><i class="fld-drawer-type fld-drawer-type-d dr-footer-anim apmc ap-drawer pr-animated ape-fadeInRight"></i><i class="fld-drawer-type fld-drawer-type-f dr-footer-anim apmc ap-circle pr-animated ape-fadeInRight"></i><div>&nbsp;</div><div>'.$this->__('fadeInRight').'</div></div>',
	
	                                ];
                                 
	                                APBD_GetHTMLRadioBoxByArray("dr_anim","dr_anim","dr_anim",true,$anim_options,$anim_selected,false,'','bg-green',null);
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="hide_corner_circle" class="col-xl-3 col-form-label pt-0 pr-sm-0">
                            <?php $this->_e("Hide Circle");
                            APBD_get_help_button("#hide-circle");
                        ?>
                        </label>
                        <div class="col-xl inline-switch">
			                <?php
				                APBD_GetHTMLSwitchButtonInline("hide_corner_circle","hide_corner_circle","N","Y",$this->GetOption("hide_corner_circle"),false,"has_depend_fld");
			                ?>
                            <small  class="form-text text-muted">
				                <?php $this->_e("if you enabled it, then circle counter of the top corner will be hide") ; ?>
                            </small>
                        </div>
                    </div>
                   
                    <div class="fld-hide-corner-circle fld-hide-corner-circle-n">
                        <hr>
                        <div class="form-group row">
                        <label for="circle_type" class="col-xl-3 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Circle Counter Type");
				                APBD_get_help_button("#type-circle");
			                ?>
                        </label>
                        <div class="col-xl ">
                            <div class="">
		                        <?php
			                        APBD_GetHTMLRadioByArray("circle_type","circle_type","circle_type",true,["I"=>$this->__("Total Item"),"Q"=>$this->__("Total Quantity")],$this->GetOption("circle_type","Q"),false,true,"");
			                        //APBD_GetHTMLSwitchButton("has_support","has_support","N","Y",$mainobj->GetPostValue("has_support"),false,"has_depend_fld2"); ?>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-success"><?php $this->_e("Save") ; ?></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xl">
        <form class="apbd-module-form"  role="form" id="<?php echo $this->GetMainFormId();?>" action="<?php echo $this->GetActionUrl(""); ?>" method="post" <?php echo $this->isMultipartForm()?' enctype="multipart/form-data" ':''; ?>>
            <div class="card apsbd-default-card mt-3">
                <div class="card-header"><i class="apmc ap-cart-container" style="font-size: 20px;vertical-align: -2px;"></i> <?php $this->_e("Cart Item Container") ; ?></div>
                <div class="card-body p-3">
                    <div class="form-group row">
                        <label for="title_text" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Title Text");
				                APBD_get_help_button("#help-title");
			                ?>
                        </label>
                        <div class="col-xl">
                            <input type="text" class="form-control text-small-caps" id="title_text" name="title_text" value="<?php echo $this->GetOption("title_text",'My Cart') ?>" placeholder="<?php $this->_e("My Cart") ; ?>">
                            <small  class="form-text text-muted">
				                <?php $this->_e("It will show into header as title in cart") ; ?>
                            </small>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="is_undo_remove" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Undo Remove Panel");
				                APBD_get_help_button("#help-undo-remove");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
			                <?php
				                APBD_GetHTMLSwitchButtonInline("is_undo_remove","is_undo_remove","N","Y",$this->GetOption("is_undo_remove",'Y'),false,"");
			                ?>
                            <small  class="form-text text-muted d-inline">
				                <?php $this->_e("if you enabled it, remove undo panel will be displayed into cart") ; ?>
                            </small>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="is_show_dis_total" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Show Discount & Cart Total");
				                APBD_get_help_button("#help-dis-ctotal");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
			                <?php
				                APBD_GetHTMLSwitchButtonInline("is_show_dis_total","is_show_dis_total","N","Y",$this->GetOption("is_show_dis_total",'N'),false,"has_depend_fld");
			                ?>
                            <small  class="form-text text-muted">
				                <?php $this->_e("if you enabled it, then discount & cart total will be displayed into cart") ; ?>
                            </small>
                        </div>
                    </div>
                    <div class="fld-is-show-dis-total fld-is-show-dis-total-y">
                    <hr>
                    <div class="form-group row ">
                        <label for="is_show_all_fee" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Show All Fees");
				                APBD_get_help_button("#help-dis-full");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
			                <?php
				                APBD_GetHTMLSwitchButtonInline("is_show_all_fee","is_show_all_fee","N","Y",$this->GetOption("is_show_all_fee",'N'),false,"");
			                ?>
                            <small  class="form-text text-muted">
				                <?php $this->_e("if you enabled it, then shipping total, total fee, total tax will be displayed into cart") ; ?>
                            </small>
                        </div>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row pt-1">
                        <label for="is_coupon_input" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Show Coupon Input");
				                APBD_get_help_button("#help-coupon-input");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
                            <div class="material-switch material-switch-sm inline mt-0">
                                <button id="is_coupon_input" class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                            </div>
                            <small  class="form-text text-muted d-inline mt-0">
				                <?php $this->_e("if you enabled it then coupon input box will be show in cart") ; ?>
                            </small>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group row pt-1">
                        <label for="is_coupon_input" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Applied Coupon Panel");
				                APBD_get_help_button("#help-applied-coupon","right");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
                            <div class="material-switch material-switch-sm inline mt-0">
                                <button id="is_coupon_input" class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                            </div>
                            <small  class="form-text text-muted d-inline mt-0">
				                <?php $this->_e("if you enabled it then applied coupon panle will be displayed in cart") ; ?>
                            </small>
                        </div>
                    </div>


                    <hr>
                    <div class="form-group row">
                        <label for="is_cart_btn" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Enable Cart Button");
				                APBD_get_help_button("#help-view-full-cart");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
			                <?php
				                APBD_GetHTMLSwitchButtonInline("is_cart_btn","is_cart_btn","N","Y",$this->GetOption("is_cart_btn",'Y'),false,"has_depend_fld");
			                ?>
                            <small  class="form-text text-muted d-inline">
				                <?php $this->_e("if you enabled it, View full cart button will be displayed into cart footer") ; ?>
                            </small>
                        </div>
                    </div>
                    <div class="form-group row fld-is-cart-btn fld-is-cart-btn-y">
                        <label for="title_text" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Cart Button Text");
				                APBD_get_help_button("#help-view-full-cart");
			                ?>
                        </label>
                        <div class="col-xl">
                            <input type="text" class="form-control form-control-sm" id="cart_btn_text" name="cart_btn_text" value="<?php echo $this->GetOption("cart_btn_text",$this->__('View Full Cart')); ?>" placeholder="<?php $this->_e("View Full Cart") ; ?>">
                            <small  class="form-text text-muted">
				                <?php $this->_e("It will show into the checkout button") ; ?>
                            </small>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="is_checkout_btn" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Enable Checkout Button");
				                APBD_get_help_button("#help-view-checkout");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
			                <?php
				                APBD_GetHTMLSwitchButtonInline("is_checkout_btn","is_checkout_btn","N","Y",$this->GetOption("is_checkout_btn",'Y'),false,"has_depend_fld");
			                ?>
                            <small  class="form-text text-muted d-inline">
				                <?php $this->_e("if you enabled it, View full cart buttion will be displayed into cart footer") ; ?>
                            </small>
                        </div>
                    </div>
                    <div class="form-group row fld-is-checkout-btn fld-is-checkout-btn-y">
                        <label for="title_text" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Checkout Button Text");
				                APBD_get_help_button("#help-view-checkout");
			                ?>
                        </label>
                        <div class="col-xl">
                            <input type="text" class="form-control form-control-sm" id="checkout_btn_text" name="checkout_btn_text" value="<?php echo $this->GetOption("checkout_btn_text",$this->__('Checkout')); ?>" placeholder="<?php $this->_e("Checkout") ; ?>">
                            <small  class="form-text text-muted">
				                <?php $this->_e("It will show into header as title in cart") ; ?>
                            </small>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row fld-is-checkout-btn fld-is-checkout-btn-y">
                        <label for="empty_txt" class="col-xl-4 col-form-label pt-0 pr-sm-0">
			                <?php $this->_e("Cart Empty Text");
				                APBD_get_help_button("#help-empty-text");
			                ?>
                        </label>
                        <div class="col-xl inline-switch">
                            <div class="material-switch material-switch-sm inline mt-0">
                                <button id="is_coupon_input" class="btn btn-xs btn-warning apbd-pro-btn mr-2 position-absolute"><?php $this->_e("Unlock It") ; ?></button>
                            </div>
                            <small  class="form-text text-muted d-inline mt-0">
	                            <?php $this->_e("It will show into cart empty text") ; ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-success"><?php $this->_e("Save") ; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="apbd-tooltip-container" class="d-none">
    <div id="icon-popover">
        <div class="apbd-po-container">
            <img src="<?php echo plugins_url( 'images/helps/icon-help.jpg', $this->pluginFile ) ?>" alt="Icon Help">
        </div>
    </div>
    <div id="drawer-type-popover">
        <div class="apbd-po-container">
            <img src="<?php echo plugins_url( 'images/helps/drawer-type-help.jpg', $this->pluginFile ) ?>" alt="Icon Help">
        </div>
    </div>
    <div id="drawer-animation">
        <div class="apbd-po-container ">
            <div class="row">
                <div class="col-4" >
                    <i class="apmc ap-drawer animated ape-jello pb-3 pt-3 pr-3" style="font-size: 100px; color: #2d6a88;"></i>
                </div>
                <div class="col pt-3">
                    <?php $this->_e("It will animated when display after page load and any change in cart items") ; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="hide-circle">
        <div class="apbd-po-container pr-3">
            <div class="row">
                <div class="col-4 position-relative" >
                    <i class="apmc ap-drawer pb-3 pt-3 pr-3" style="font-size: 100px; color: #2d6a88;"></i>
                    <i class="apmc ap-circle-o animated infinite apf-flash" style="font-size: 42px; color: #fb2f3a;position: absolute;top: 0.67rem;left: 3.71rem;"></i>
                </div>
                <div class="col p-3">
					<?php $this->_e("If you enabled it, then circle will be hide") ; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="type-circle">
        <div class="apbd-po-container pr-3 ">
            <div class="row">
                <div class="col-4 position-relative" >
                    <i class="apmc ap-drawer pb-3 pt-3 pr-3" style="font-size: 100px; color: #2d6a88;"></i>
                    <i class="apmc ap-circle-o animated infinite apf-flash" style="font-size: 42px; color: #fb2f3a;position: absolute;top: 0.67rem;left: 3.71rem;"></i>
                </div>
                <div class="col p-3">
					<?php $this->_e("Choose the circle counter type") ; ?>
                </div>
            </div>
        </div>
    </div>
    <div id="help-dis-ctotal">
        <div class="apbd-po-container pr-3 full-width">
            <img class="max-w-400" src="<?php echo plugins_url( 'images/helps/sub-total-to-discount.jpg', $this->pluginFile ) ?>" alt="Icon Help">
        </div>
    </div>

    <div id="help-dis-full">
        <div class="apbd-po-container pr-3 full-width">
            <img class="max-w-400" src="<?php echo plugins_url( 'images/helps/container-dis-full.jpg', $this->pluginFile ) ?>" alt="Icon Help">
        </div>
    </div>
    <div id="help-coupon-input">
        <div class="apbd-po-container pr-3 ">
            <img class="max-h-400" src="<?php echo plugins_url( 'images/helps/coupon.jpg', $this->pluginFile ) ?>" alt="Icon Help">
        </div>
    </div>
    <div id="help-applied-coupon">
        <div class="apbd-po-container pr-3 ">
            <img class="max-h-400" src="<?php echo plugins_url( 'images/helps/applied-coupon.jpg', $this->pluginFile ) ?>" alt="Icon Help">
        </div>
    </div>
    <div id="help-view-full-cart">
        <div class="apbd-po-container p-3 full-width">
            <img class="max-h-400" src="<?php echo plugins_url( 'images/helps/view_full-cart.jpg', $this->pluginFile ) ?>" alt="view_full-cart">
        </div>
    </div>
    <div id="help-view-checkout">
        <div class="apbd-po-container p-3 full-width">
            <img class="max-h-400" src="<?php echo plugins_url( 'images/helps/view-checkout.jpg', $this->pluginFile ) ?>" alt="view_full-cart">
        </div>
    </div>
    <div id="help-title">
        <div class="apbd-po-container p-3 full-width">
            <img class="max-h-300" src="<?php echo plugins_url( 'images/helps/help-title.jpg', $this->pluginFile ) ?>" alt="view_full-cart">
        </div>
    </div>
    <div id="help-undo-remove">
        <div class="apbd-po-container pb-2 full-width">
            <img class="max-w-300" src="<?php echo plugins_url( 'images/helps/help-undo-remove.jpg', $this->pluginFile ) ?>" alt="Undo Remove">
        </div>
    </div>
    <div id="help-empty-text">
        <div class="apbd-po-container pb-2 full-width">
            <img class="max-w-300" src="<?php echo plugins_url( 'images/helps/empty-cart-text.jpg', $this->pluginFile ) ?>" alt="Empty Text">
        </div>
    </div>
</div>
<script>
    function apd_value_format(val, px,type){
        return type=='C'?("<?php $this->_e("Current Value"); ?> : "+val+px):val+px;
    }
    jQuery( document ).ready(function( $ ) {
        $("input[name=drawer_type]").on("change",function(){
            apbd_init_wmc_settings();
        });
        apbd_init_wmc_settings();
        function apbd_init_wmc_settings() {
            let v=$("input[name=drawer_type]:checked").val();
            if(v=="F"){
                let pos=$("input[name=position]:checked").val();

                if(['LB','LM'].indexOf(pos)>-1) {
                    $("input[name=position][value=LB]").prop('checked', true);
                }
                if(['RM','RT'].indexOf(pos)>-1){
                    $("input[name=position][value=RB]").prop('checked', true);
                }
                $("input[name=position][value='LT'],input[name=position][value='LM'],input[name=position][value='RT'],input[name=position][value='RM']").closest('.apbd-app-box-option').hide();
            }else{
                $("input[name=position][value='LT'],input[name=position][value='LM'],input[name=position][value='RT'],input[name=position][value='RM']").closest('.apbd-app-box-option').show();
            }
        }
    });
</script>