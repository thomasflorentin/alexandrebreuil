<?php function konzept_theme_options_page_demo() { ?>

	<div class="wrap">

		<h2 class="title">Import the demo content</h2>

		<?php
			if ( ! is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) {
				echo '<p>' . __( 'WordPress Importer plugin is not active. Install and activate it in <b>Tools &rarr; Import</b> to be able to view this page and import the demo content.', 'konzept' ) . '</p>';
				
				return;
			}

			$acf_active = is_plugin_active( 'advanced-custom-fields/acf.php' ) || class_exists('acf') ? true : false;
			$cf7_active = is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ? true : false;
			$wc_active = is_plugin_active( 'woocommerce/woocommerce.php' ) ? true : false;
		?>

		<p>To import the demo content follow the steps below and click the import button.</p>

		<ol class="bl-list-import-demo">
			<?php /* if ( $acf_active ) { ?>
				<li style="color: #0a0;"><span class="ik-label active">Active</span> Install and activate Advanced Custom Fields plugin or the theme's custom fields won't be imported.</li>
			<?php } else { ?>
				<li style="color: #f00;"><span class="ik-label inactive">Inactive</span> Install and activate Advanced Custom Fields plugin or custom fields won't be imported.</li>
			<?php } */ ?>
			
			<?php if ( $cf7_active ) { ?>
				<li style="color: #0a0;"><span class="ik-label active">Active</span> Install and activate Contact From 7 plugin or the contact form won't be imported.</li>
			<?php } else { ?>
				<li style="color: #f00;"><span class="ik-label inactive">Inactive</span> Install and activate Contact From 7 plugin or the contact form won't be imported.</li>
			<?php } ?>

			<li style="color: #f00;"><span class="ik-label" style="background: #f00;">Info</span> Version 0.6.3 of the official WordPress Importer plugin comes with an issue that on some servers (running PHP newer than 5.6) the menu may not be imported despite being included in the export XML file. You can create it in <b>Appearance &rarr; Menus</b> if you're affected and if the issue hasn't been fixed yet.</li>
			<li><span class="ik-label">Consider</span> The demo content will be added in addition to the existing content so you may consider removing the existing content first or skipping the import of some parts of the content.</li>
			<li><span class="ik-label">Consider</span> Before importing, consider <a href="http://codex.wordpress.org/WordPress_Backups">backing up your database</a>.</li>
			<li><span class="ik-label">Info</span> This page uses the official <a href="https://wordpress.org/plugins/wordpress-importer/" target="_blank">WordPress Importer plugin</a> which is also available in <b>Tools &rarr; Import</b> and you can alternatively load there any XML file from /admin/auto-install/ folder manually.</li>
			<li><span class="ik-label">Info</span> Importing can take up to a few minutes. Do not leave or refresh the page while it is in progress.</li>
			<li><span class="ik-label">Info</span> Repeateadly using the import button will not import duplicate posts and other data. It will only import missing posts.</li>
		</ol>
		
		<?php
			function konzept_demo_content_list() {
				$available_importers = get_importers();
				
				if ( is_array( $available_importers ) && array_key_exists( 'wordpress', $available_importers ) ) {
					return;
				}
				
				$demo_content_default = get_template_directory() . '/admin/auto-install/konzept-default-2017-08-03.xml';
				// $demo_content_acf = get_template_directory() . '/admin/auto-install/konzept-acf-2017-07-22.xml';
				// $demo_content_wc = get_template_directory() . '/admin/auto-install/konzept-woocommerce-2017-07-17.xml';
				// $demo_content_wc_media = get_template_directory() . '/admin/auto-install/konzept-woocommerce-media-2017-07-17.xml';
				$demo_content_wpcf7 = get_template_directory() . '/admin/auto-install/konzept-wpcf7-2017-08-03.xml';
				
				if ( ! class_exists( 'WXR_Parser' ) && file_exists( WP_PLUGIN_DIR . '/wordpress-importer/parsers.php' ) ) {
					require WP_PLUGIN_DIR . '/wordpress-importer/parsers.php';
				}
				
				function konzept_demo_content_list_print( $file ) {
					$parser = new WXR_Parser();
					$parsed_data = $parser->parse( $file );
				
					echo '<table class="demo-content-list">';
					
					foreach ( $parsed_data as $key => $value ) {
						
						// ACF fields list.
						// if($key === 'posts'){
							// foreach ( $value as $key2 => $value2 ) {
								// foreach ( $value2['postmeta'] as $key3 => $value3 ) {
									// $unserialized = unserialize($value3['value']);
									
									// if(preg_match('/^field_/', $unserialized['key'])){
										// var_dump($unserialized['label']);
										// var_dump($unserialized['name']);
									// }
								// }
							// }
						// }
						
						if($key === 'posts'){
							$post_type_sorting = array();
							
							foreach ( $value as $key2 => $value2 ) {
								$post_type_sorting[$key2] = $value2['post_type'];
							}
							
							array_multisort( $post_type_sorting, SORT_ASC, $value );
							
							foreach ( $value as $key2 => $value2 ) {
								$class = 'style=""';
								$description = "This item will be imported if it doesn't exist yet.";
								
								if ( $value2['post_type'] === 'attachment' ) {
									$class = 'style="color: #aaa;"';
									$description = "Media library items won't be downloaded to your server.";
								}
								
								echo '<tr ' . $class . '>
									<td>' . $value2[ 'post_type' ] . '</td>
									<td>' . $value2[ 'post_title' ] . '</td>
									<td>' . $description . '</td>
								</tr>';
							}
						}
					}
					
					echo '</table>';
				}
				
				echo '<div class="demo-content-import">';
					echo '<h2>Select the checkbox next to the items you want to import</h2>';
					echo '<ol>';
						// echo '<li><label><input class="demo-content-select" type="checkbox" name="acf" checked> (Required.) Import Advanced Custom Fields data.</label>';
							// konzept_demo_content_list_print( $demo_content_acf );
						// echo '</li>';
						echo '<li><label><input class="demo-content-select" type="checkbox" name="default" checked> (Optional.) Import the default demo content.</label>';
							konzept_demo_content_list_print( $demo_content_default );
						echo '</li>';
						echo '<li><label><input class="demo-content-select" type="checkbox" name="wpcf7" checked> (Optional.) Import the demo contact form.</label>';
							konzept_demo_content_list_print( $demo_content_wpcf7 );
						echo '</li>';
						// echo '<li><label><input class="demo-content-select" type="checkbox" name="wc"> (Optional.) Import the demo WooCommerce content.</label>';
							// konzept_demo_content_list_print( $demo_content_wc_media );
							// konzept_demo_content_list_print( $demo_content_wc );
						// echo '</li>';
						echo '<li><label><input class="demo-content-select" type="checkbox" name="database" checked> (Optional.) Update the database options.</label>';
							echo '<ol>
								<li>You should also import the default demo content if you use this option or missing pages won\'t be assigned.</li>
							</ol>';
							global $wordpress_settings;
							global $theme_settings;
							echo konzept_demo_settings_list( $wordpress_settings );
							echo konzept_demo_settings_list( $theme_settings );
							echo '<ol start="2">
								<li>All your "Custom HTML" widgets will be deleted and replaced with the demo widgets.</li>
								<li>Your <b>Customize &rarr; Additional CSS</b> will be replaced with the demo CSS for this theme.</li>
							</ol>';
							
						echo '</li>';
					echo '</ol>';
				echo '</div>';
			}
			konzept_demo_content_list();
		
			global $out;
			
			if(empty($out) && $_GET['import'] !== 'wordpress'){
		?>
		
		<div class="demo-boxf">
			<p><a href="<?php echo wp_nonce_url( add_query_arg( array( 'demo_version' => 'default|wpcf7|database', 'import' => 'wordpress' ), get_admin_url( null, 'admin.php?page=konzept-theme-options-demo' ) ), 'install_demo', 'import_nonce' ); ?>" class="button button-primary button-large button-install-demo"><?php _e( 'Import the demo content', 'konzept' ); ?></a></p>
		</div>

		<?php
			}else{
				echo '<h2>Import status by WordPress Importer plugin</h2>';
				echo '<span style="color: #0a0;">The selected items were imported. The items that already exist were skipped.</span><br><br>';
				echo preg_replace('/Failed to import Media(.*?)<br \/>/', '', $out);
			}
		?>
	</div>

<?php
}
