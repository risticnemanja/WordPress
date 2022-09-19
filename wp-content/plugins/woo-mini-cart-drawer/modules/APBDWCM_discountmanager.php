<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	/**
	 * @property APBD_discount_item[]   $offers
	 */
	class APBDWCM_discountmanager extends AppsBDLiteModule {
		private $temp_code=null;
		public $active_currency;
		public $mini_cart_customer_menu;
		public $offers=[];
		public $nextOffer=null;
		public $currentOffer=null;
		function initialize() {
			parent::initialize();
		}
		function OnInit() {
			parent::OnInit();
		}
		function GetMenuSubTitle() {
			return $this->__("Manage dynamic discount");
		}
		function GetMenuIcon() {
			return 'apmc ap-boost-sale-2 ';
		}
		
		function GetMenuTitle() {
			return $this->__("Sale Booster");
		}
		function SettingsPage() {
			$this->Display();
		}
		public function GetMenuCounter() {
			return '<span class=" apbd-tab-counter badge badge-info animated ani-count-3 delay-1s slower flash">'.$this->__("PRO").'</span>';
		}
	}