<?php
	/**
	 * @since: 07/09/2019
	 * @author: Sarwar Hasan
	 * @version 1.0.0
	 */
	/**
	 * @property APBDWC_currency_item   $active_currency
	 */
	class APBDWCM_aboutus extends AppsBDLiteModule {
	    public static $recommended_data=null;
	    public static $is_called=false;
		function initialize() {
			parent::initialize();
			$this->disableDefaultForm();
			$this->SetRecommendedTopNotification();
			$this->AddAjaxAction("dismiss-notice",[$this,"dismiss_notice"]);
			$this->AddAjaxNoPrivAction("dismiss-notice",[$this,"dismiss_notice"]);
		}
		function GetMenuSubTitle() {
			return $this->__("Recommended by %s","APPSBD");
		}
		
		function GetMenuIcon() {
			return 'fa fa-thumbs-up animated apf-pulse';
		}
		
		
		function GetMenuTitle() {
			return $this->__("Recommended");
		}
		function isInstalledAddon($plugin_path) {
			$plugins = get_plugins();
			return isset( $plugins[ $plugin_path ] );
		}
		function isActivatedAddon($plugin_path) {
			$activates = get_option( 'active_plugins' );
			return in_array($plugin_path,$activates);
		}
		function SetRecommendedTopNotification(){
		    $data=self::getRecommendedData();
		    if(!empty($data->top_notifications)){
		        foreach ($data->top_notifications as $top_notification){
			        if(!$this->is_dismissed_notice($top_notification)) {
				        APBDAjaxMiniCart::GetInstance()->AddAdminNoticePlain( $this->notice_body( $top_notification) );
			        }
                }
            }
			
        }
		public static function &getRecommendedData(){
			self::$recommended_data       = get_transient( "_minicart_rcom" );
			if (!self::$is_called && empty( self::$recommended_data ) ) {
				self::$is_called=true;
			    $link='https://appsbd.com/etc/recom/?f=minicart';
				$serverResponse = wp_remote_get( $link, ['sslverify' => false,'timeout'   => 120,'blocking'  => true] );
				if(!is_wp_error($serverResponse) && ( ! empty( $serverResponse['body'] ) && ( is_array( $serverResponse ) && 200 === (int) wp_remote_retrieve_response_code( $serverResponse )))) {
					self::$recommended_data  = json_decode(  $serverResponse['body'] );
					if(!empty(self::$recommended_data)) {
						set_transient( "_minicart_rcom", self::$recommended_data, DAY_IN_SECONDS );
					}
				}
			}
			if(empty(self::$recommended_data)){
				self::$recommended_data=null;
            }
			return self::$recommended_data;
        }
		function get_nonce_url($plugin_slug,$action='install-plugin'){
			return wp_nonce_url(
				add_query_arg(
					array(
						'action' => $action,
						'plugin' => $plugin_slug
					),
					admin_url( 'update.php' )
				),
				$action . '_' . $plugin_slug
			);
		}
		function get_install_url($plugin_slug) {
			return $this->get_nonce_url($plugin_slug,'install-plugin');
		}
		function get_activate_install_url($plugin_path) {
			$activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin_path);
			
			// change the plugin request to the plugin to pass the nonce check
			$_REQUEST['plugin'] = $plugin_path;
			$activateUrl = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin_path);
			
			return $activateUrl;
		}
		function getButtonInstallLink($slug,$plugin_path,$pro_version_paths=[]){
			$response=new stdClass();
			$response->title="Install";
			$response->cssClass="btn-success";
			$response->isDisabled=false;
			$response->url=$this->get_install_url($slug);
			foreach ( $pro_version_paths as $pro_version_path_link ) {
				if($this->isInstalledAddon($pro_version_path_link)) {
					if (!$this->isActivatedAddon( $pro_version_path_link ) ) {
						$response             = new stdClass();
						$response->title      = "Active";
						$response->cssClass   = "btn-success";
						$response->isDisabled = false;
						$response->url        = $this->get_activate_install_url( $pro_version_path_link );
						return $response;
					}else{
						$response             = new stdClass();
						$response->title      = "Activated";
						$response->cssClass   = "btn-secondary";
						$response->isDisabled = true;
						$response->url        = "";
						return $response;
					}
				}
			}
			
			if(!$this->isInstalledAddon($plugin_path)){
				return $response;
			}elseif(!$this->isActivatedAddon($plugin_path)){
				$response=new stdClass();
				$response->title="Active";
				$response->cssClass="btn-success";
				$response->isDisabled=false;
				$response->url=$this->get_activate_install_url($plugin_path);
				return $response;
			}else{
				
				
				$response=new stdClass();
				$response->title="Activated";
				$response->cssClass="btn-secondary";
				$response->isDisabled=true;
				$response->url='';
				return $response;
			}
			
		}
		function getButtonInstallLinkHtml($slug,$plugin_path,$pro_version_paths=[]) {
			$pluginObject=$this->getButtonInstallLink($slug,$plugin_path,$pro_version_paths);
			ob_start();
			if(!empty($pluginObject->isDisabled)) {?>
				<button  class="btn  <?php echo $pluginObject->cssClass; ?> btn-sm" disabled ><?php echo $pluginObject->title; ?></button>
			<?php }else{?>
				<a href="<?php echo $pluginObject->url; ?>" target="_blank" class="btn  <?php echo $pluginObject->cssClass; ?> btn-sm" <?php echo !empty($pluginObject->isDisabled)?"disabled":""; ?> ><?php echo $pluginObject->title; ?></a>
			<?php }
			return ob_get_clean();
		}
		function SettingsPage() {
			$this->Display();
		}
		function dismiss_notice() {
			$id = APBD_GetValue( "id" );
			
			if ( !isset( $this->options['notices'] ) || !is_array($this->options['notices']) ) {
				$this->options['notices'] = [];
			}
			if ( ! in_array( $id, $this->options['notices'] ) ) {
				$this->options['notices'] []= $id;
				$this->UpdateOption();
			}
			$res=new AppsbdAjaxConfirmResponse();
			$res->DisplayWithResponse(true,"Removed");
		}
		function is_dismissed_notice($top_notification){
		    if(empty($top_notification->id)){
		        return true;
		    }
			if ( !isset( $this->options['notices'] ) || !is_array($this->options['notices']) ) {
				$this->options['notices'] = [];
			}
			if(!$this->kernelObject->CheckAdminPage() && (in_array($top_notification->id,$this->options['notices']))){
				return true;
			}
			if($this->isInstalledAddon( $top_notification->plugin_path)){
			    return true;
			}
			foreach ( $top_notification->pro_plugin_paths as $plugin_path ) {
				if($this->isInstalledAddon( $plugin_path)){
					return true;
				}
			}
			return false;
		}
		function notice_body($top_notification){
			ob_start()
			?>
            <div class="notice apbd-notice-st1 is-flex">
                <div class="apbd-notice-title">
                   <?php echo $top_notification->title; ?>
                </div>
                <div class="">
	                <?php echo $top_notification->short_dtls; ?>
                </div>
                <div class="">
                    <?php if($top_notification->is_wp_org){ ?>
                        <a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&plugin='.$top_notification->slug.'&TB_iframe=true&width=772&height=462&modal_window=true'); ?>" target="_blank" class="apbd-nt-btn">View Details</a>
                      
                    <?php }else{
                        if(!empty($top_notification->link)){
                        ?>
                        <a href="<?php echo $top_notification->link; ?>" target="_blank" class="apbd-nt-btn">View Details</a>
                    <?php }
                    }
                    if(!$this->kernelObject->CheckAdminPage()){
                    ?>
                    <a href="<?php echo $this->GetActionUrl("dismiss-notice",["id"=>$top_notification->id])?>" class="apbd-remove-nt mt-1"><span class="dashicons dashicons-dismiss"></span> <?php $this->_e("Dismiss") ; ?></a>
                        <?php } ?>
                </div>
            </div>
			<?php
			return ob_get_clean();
		}
		public function GetMenuCounter() {
		    $data=self::getRecommendedData();
		    $coutner=!empty($data->recommended_plugins) && is_array($data->recommended_plugins)?count($data->recommended_plugins):0;
		    if($coutner>0) {
			    return '<span class=" apbd-tab-counter badge badge-danger animated ani-count-3 delay-1s slower flash">' . $coutner . '</span>';
		    }
		    return '';
		}
	}