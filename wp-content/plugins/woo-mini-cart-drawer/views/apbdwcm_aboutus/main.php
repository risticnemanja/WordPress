<div class="row">
    <div class="col">
        <div class="apbd-recommended-container mt-3">
            <div class="row row-cols-sm-3 pr-sm-3">
				<?php
					$recommendedData = APBDWCM_aboutus::getRecommendedData();
					if ( ! empty( $recommendedData->recommended_plugins ) && is_array( $recommendedData->recommended_plugins ) ) {
						foreach ( $recommendedData->recommended_plugins as $apbd_plugin ) { ?>
                            <div class="col pr-sm-0">
                                <div class="card animated ape-fadeIn mb-3 ">
                                    <div class="card-body pt-3 pl-3 pr-3">
                                        <div class="card-title">
                                            <div class="apbd-app-logo">
                                                <img class="img-fluid" src="<?php echo $apbd_plugin->image_link; ?>" alt=" ">
                                            </div>
                                            <div class="apbd-app-title app-tooltip" title="WooLentor">
	                                            <?php echo $apbd_plugin->title; ?>
                                                <small><?php echo $apbd_plugin->author; ?></small>
                                            </div>
                                        </div>
                                        <div class="app-rec-dtls">
	                                        <?php echo $apbd_plugin->short_dtls; ?>
                                        </div>
                                    </div>
                                    <div class="card-footer app-rec-buttons text-right">
										<?php echo $this->getButtonInstallLinkHtml( $apbd_plugin->slug, $apbd_plugin->plugin_path, $apbd_plugin->pro_plugin_paths );
										   if($apbd_plugin->is_wp_org){ ?>
                                            <a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&plugin='.$apbd_plugin->slug.'&TB_iframe=true&width=772&height=662'); ?>" target="_blank" class="btn btn-info btn-sm">View Details</a>
                                        <?php }else{
                                            if(!empty($apbd_plugin->link)){
                                                ?>
                                                <a href="<?php echo $apbd_plugin->link; ?>" target="_blank" class="btn btn-info btn-sm">View Details</a>
                                            <?php }
                                           }
                                            ?>
                                    </div>
                                </div>
                            </div>
						<?php }
					}
				?>

            </div>
        </div>
    </div>
</div>