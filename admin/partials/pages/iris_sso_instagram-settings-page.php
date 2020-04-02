<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo __( 'IRIS SSO Instagram settings', IRIS_SSO_INSTAGRAM_DOMAIN ) ?></h1>
	<hr class="wp-header-end">
	<div class="notice notice-info">
		<p><?php _e( 'Follow this <a target="_blank" href="https://developers.facebook.com/docs/instagram-basic-display-api/getting-started#-tapes-suivantes">documentation</a> for generate the below settings', IRIS_SSO_INSTAGRAM_DOMAIN ) ?></p>
		<p><?php _e( 'Set this URL for the fields Redirect URI <strong>' . trailingslashit( get_rest_url( get_current_blog_id() , '/iris-sso-instagram/v1/auth' ) ), IRIS_SSO_INSTAGRAM_DOMAIN ) ?></strong></p>
		<p><?php _e( 'When you have filled this settings, click on submit button, then click on authorize button and follow the instructions', IRIS_SSO_INSTAGRAM_DOMAIN ) ?></p>
	</div>
	<form method="POST" enctype="multipart/form-data" id="post">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="postbox-container-2" class="postbox-container">
					<div class="postbox">
						<button type="button" class="handlediv button-div">
							<span class="screen-reader-text"></span>
							<span class="toggle-indicator" aria-hidden="true"></span>
						</button>
						<h2 class="handle ui-sortable-handle">
							<span><?php _e( 'Fill this settings', IRIS_SSO_INSTAGRAM_DOMAIN ) ?></span>
						</h2>
						<div class="inside">
							<?php
							$iris_sso_instagram_client_id = get_option( IRIS_SSO_INSTAGRAM_CLIENT_ID, '' );
							$iris_sso_instagram_client_secret = get_option( IRIS_SSO_INSTAGRAM_CLIENT_SECRET, '' );
							$iris_sso_instagram_code = get_option( IRIS_SSO_INSTAGRAM_CODE, '' );
							$iris_sso_instagram_token = json_decode( get_option( IRIS_SSO_INSTAGRAM_TOKEN, '' ) );

							try {
								$tplz = \IrisSsoInstagram\includes\IrisSsoInstagramFactory::get_dependence( 'templatizer' );
								$tplz::get_meta_box( 'client-id', $iris_sso_instagram_client_id );
								$tplz::get_meta_box( 'client-secret', $iris_sso_instagram_client_secret );
								$tplz::get_meta_box( 'code', $iris_sso_instagram_code );
							} catch(\IrisSsoInstagram\includes\IrisSsoInstagramException $iris_sso_instagram_exception) {
								echo $iris_sso_instagram_exception->getIrisMessage();
							}
							?>
						</div>
					</div>
					<?php
					if( !empty( $iris_sso_instagram_token ) ) {
						?>
							<div class="postbox">
								<button type="button" class="handlediv button-div">
									<span class="screen-reader-text"></span>
									<span class="toggle-indicator" aria-hidden="true"></span>
								</button>
								<h2 class="handle ui-sortable-handle">
									<span><?php echo __( 'Current token - until ', IRIS_SSO_INSTAGRAM_DOMAIN ) . date( 'd/m/Y', $iris_sso_instagram_token->expire_timestamp ) ?></span>
								</h2>
								<div class="inside">
									<ul>
										<li><strong><?php echo $iris_sso_instagram_token->access_token; ?></strong></li>
									</ul>
								</div>
							</div>
						<?php
					}
					?>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<div class="postbox">
						<button type="button" class="handlediv button-div">
							<span class="screen-reader-text"></span>
							<span class="toggle-indicator" aria-hidden="true"></span>
						</button>
						<h2 class="handle ui-sortable-handle">
							<span><?php _e( 'Usage', IRIS_SSO_INSTAGRAM_DOMAIN ) ?></span>
						</h2>
						<div class="inside">
							<p>
								<?php echo __( 'This screen allows you to enter sso instagram settings', IRIS_SSO_INSTAGRAM_DOMAIN ); ?>
							</p>
							<input type="submit" name="submit_metas" class="button button-primary" value="<?php echo __( 'Submit', IRIS_SSO_INSTAGRAM_DOMAIN ) ?>">
							<?php
							if( !empty( $iris_sso_instagram_client_id ) && !empty( $iris_sso_instagram_client_secret ) ) {
								$authorizeURL = \IrisSsoInstagram\includes\IrisSsoInstagramUtils::get_authorize_url();
							?>
								<a class="button button-primary" href="<?php echo $authorizeURL ?>">Authorize me</a>
							<?php
							}
							if( !empty( $iris_sso_instagram_code ) && !empty( $iris_sso_instagram_code ) ) {
							?>
							<input type="submit" name="refresh_token" class="button button-primary" value="<?php echo __( 'Refresh token', IRIS_SSO_INSTAGRAM_DOMAIN ) ?>">
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="clear"></div>
