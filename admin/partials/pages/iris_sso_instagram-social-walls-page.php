<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo __( 'Social walls', IRIS_SSO_INSTAGRAM_DOMAIN ) ?></h1>
	<hr class="wp-header-end">
	<form method="POST" enctype="multipart/form-data" id="post">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="postbox-container-2" class="postbox-container">
					<div class="postbox">
<!--						Call WPListTable-->
						<?php
						$listTable = new \IrisSsoInstagram\admin\IrisSsoInstagramListTable(IRIS_SSO_INSTAGRAM_LISTS_TABLE['SOCIAL_WALL']);
						?>
					</div>
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
							<a class="button button-primary" href="#"><?php echo __( 'Add', IRIS_SSO_INSTAGRAM_DOMAIN ) ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="clear"></div>
