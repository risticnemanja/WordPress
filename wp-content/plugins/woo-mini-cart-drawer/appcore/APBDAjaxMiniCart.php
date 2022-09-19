<?php
/**
 * Woo Commerce Multi Currency
 * Author: S M Sarwar Hasan
 * A Product of appsbd.com
 */

APBD_LoadCore("AppsBDKarnelLite","AppsBDKarnelLite",__FILE__);
class APBDAjaxMiniCart  extends AppsBDKarnelLite {
	function __construct( $pluginBaseFile, $version = '1.0.0' ) {
		$this->pluginFile     = $pluginBaseFile;
		$this->pluginSlugName = 'woo-mini-cart-drawer';
		$this->pluginName     = 'Mini Cart Drawer For WooCommerce';
		$this->pluginVersion  = $version;
		parent::__construct($pluginBaseFile,$version);
		$this->setMenuTitle("Mini Cart Drawer");
	}
	
	public function initialize() {
		parent::initialize();
		//$this->SetIsLoadJqGrid(true);
		$this->SetPluginIconClass("apmc ap-mca-logo",'dashicons-apbd-mca');
		$this->setSetActionPrefix("apbd_woominiajax");
		
		$this->AddliteModule("APBDWCM_settings");
		$this->AddliteModule("APBDWCM_discountmanager");
		$this->AddliteModule("APBDWCM_aboutus");
		
		
	}
	public function  OnAdminGlobalScripts() {
		parent::OnAdminGlobalScripts();
		$this->AddAdminScript( "mini-cart-global-js", "mini-cart-global.js",false,['jquery','thickbox']);
	}
	
	public function OnAdminGlobalStyles() {
		parent::OnAdminGlobalStyles();
		$this->AddAdminStyle("apbd-woo-mini-cart-icon","font-for-admin.css");
		$this->AddAdminStyle("thickbox");
	}
	
	public function OnAdminAppStyles() {
		$this->AddAdminStyle( "apsbdboostrap", "uilib/boostrap/4.6.0/css/bootstrap.min.css", true );
		parent::OnAdminAppStyles();
		$this->AddAdminStyle("bootstrap-material-css","uilib/material/material.css",true);
		
	}

	public function OnAdminAppScripts() {
		parent::OnAdminAppScripts();
		$this->AddAdminScript( "boostrap4", "uilib/boostrap/4.6.0/js/bootstrap.bundle.min.js", true );
		$this->SetLocalizeScript("boostrap4");
		
		$this->AddAdminScript( "apd-app-main-js", "app_admin.min.js");
	}
	
	function GetHeaderHtml() {
	
	}

	function GetFooterHtml() {
	
	}

	
	static function StartApp( $fileName ) {

	}
}