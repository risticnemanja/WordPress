<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	/**
	 * @property APBDWC_currency_item   $active_currency
	 */
	class APBDWCM_aboutus extends AppsBDLiteModule{
		private $temp_code=null;
		public $active_currency;
		function initialize() {
			parent::initialize();
			
			$this->disableDefaultForm();
			
			
		}
		function OnInit() {
			parent::OnInit();
			$this->LoadContent();
		}
		
		function GetMenuSubTitle() {
			return $this->__("About %s","APPSBD");
		}
		
		function GetMenuIcon() {
			return 'apmc ap-appsbd';
		}
		
		
		function GetMenuTitle() {
			return $this->__("About %s","APPSBD");
		}
		function LoadContent(){
			$lastRequestTime=$this->GetOption("apbd_mca_ab_time",0);
			if($lastRequestTime<time()){
				$data=wp_remote_get('https://appsbd.com/etc/appsbd/', [ 'sslverify' => false, 'timeout' => 120]);
				if (!is_wp_error($data)) {
					$this->AddOption("apbd_mca_ab_time",strtotime('+ 7 DAYS'));
					$this->AddOption("apbd_mca_ab",$data['body']);
				}
			}
		}
		// start form here*/
		function SettingsPage() {
			$html=$this->GetOption("apbd_mca_ab",'');
			if(!empty($html)){
			echo $html;
			}else {
				$this->Display();
			}
		}
	}