<?php
// toggle button CSS
wp_enqueue_style('awl-em-css', VG_PLUGIN_URL . 'assets/css/toogle-button.css');
wp_enqueue_style('awl-go-top-css', VG_PLUGIN_URL . 'assets/css/go-to-top.css');
wp_enqueue_style('awl-bootstrap-css', VG_PLUGIN_URL . 'assets/css/bootstrap.css');
wp_enqueue_style('awl-styles-css', VG_PLUGIN_URL . 'assets/css/styles.css');


// js
wp_enqueue_script('awl-bootstrap-js', VG_PLUGIN_URL . 'assets/js/bootstrap.js', array('jquery'), '', true);
wp_enqueue_script('awl-go-top-js', VG_PLUGIN_URL . 'assets/js/go-to-top.js', array('jquery'), '', true);


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
// css
wp_enqueue_style('vg-font-awesome-css', VG_PLUGIN_URL . 'assets/css/font-awesome.min.css');

$post_id = esc_attr($post->ID);

function is_sr_serialized($str)
{
	return ($str == serialize(false) || @unserialize($str) !== false);
}

// Retrieve the base64 encoded data
$encodedData = get_post_meta($post_id, 'awl_vg_settings_' . $post_id, true);

// Decode the base64 encoded data
$decodedData = base64_decode($encodedData);

// Check if the data is serialized
if (is_sr_serialized($decodedData)) {

	// The data is serialized, so unserialize it
	$gallery_settings = unserialize($decodedData);
	// Optionally, convert the unserialized data to JSON and save it back in base64 encoding for future access
	// This step is optional but recommended to transition your data format

	$jsonEncodedData = json_encode($gallery_settings);
	update_post_meta($post_id, 'awl_vg_settings_' . $post_id, $jsonEncodedData);

	// Now, to use the newly saved format, fetch and decode again
	$encodedData = get_post_meta($post_id, 'awl_vg_settings_' . $post_id, true);
	$gallery_settings = json_decode(($encodedData), true);

} else {
	// Assume the data is in JSON format
	$jsonData = get_post_meta($post_id, 'awl_vg_settings_' . $post_id, true);
	// Decode the JSON string into an associative array
	$gallery_settings = json_decode($jsonData, true); // Ensure true is passed to get an associative array
}

// js ?>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
<div class="row">
	<?php
	if (isset ($gallery_settings['video_gallery_option'])) {
		$video_gallery_option = $gallery_settings['video_gallery_option'];
	} else {
		$video_gallery_option = 'no_api';
	}
	?>
	<input type="radio" id="no_api" name="video_gallery_option" value="no_api" <?php if ($video_gallery_option == 'no_api') {
		echo "checked='checked'";
	} ?> style="display:none;">
	<label for="no_api">
		<div class="col-lg-6 video_gallery_genrate">
			<div class="card no_api">
				<div class="card-body text-center">
					<div class="m-b-20 m-t-10">
						<span class="dashicons dashicons-video-alt3"
							style="width:7%; margin-top:9px; lign-height:0;"></span>
					</div>
					<span class="text-white display-4">
						<?php esc_html_e('Video Gallery', 'new-video-gallery'); ?>
					</span>
				</div>
			</div>
		</div>
	</label>
	<input type="radio" id="video_yoyube_api" name="video_gallery_option" value="video_yoyube_api" <?php if ($video_gallery_option == 'video_yoyube_api') {
		echo "checked='checked'";
	} ?> style="display:none;">
	<label for="video_yoyube_api">
		<div class="col-lg-6 video_gallery_genrate">
			<div class="card video_yoyube_api">
				<div class="card-body text-center">
					<div class="m-b-20 m-t-10">
						<span class="dashicons dashicons-youtube"
							style="width:7%; margin-top:9px; lign-height:0;"></span>
					</div>
					<span class="text-white display-4">
						<?php esc_html_e('YouTube API Gallery', 'new-video-gallery'); ?>
					</span>
				</div>
			</div>
		</div>
	</label>
</div>
<div class="row video-gallery-content">
	<!--Add New Image Button-->
	<div class="file-upload">
		<div class="image-upload-wrap">
			<input class="new-slider file-upload-input" id="add-new-slider" name="add-new-slider"
				value="Upload Image" />
			<div class="drag-text">
				<h3>
					<?php esc_html_e('ADD Video Banner', 'new-video-gallery'); ?>
					<?php wp_nonce_field('vg_add_images', 'vg_add_images_nonce'); ?>
				</h3>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 bhoechie-tab-container">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu">
			<div class="list-group">
				<a href="#" class="list-group-item active text-center">
					<span class="dashicons dashicons-format-video"></span><br />
					<?php esc_html_e('Add Video', 'new-video-gallery'); ?>
				</a>
				<a href="#" class="list-group-item text-center no-api-config">
					<span class="dashicons dashicons-admin-generic"></span><br />
					<?php esc_html_e('Config', 'new-video-gallery'); ?>
				</a>
				<a href="#" class="list-group-item text-center no-api-config">
					<span class="dashicons dashicons-controls-pause"></span><br />
					<?php esc_html_e('Auto Play Setting', 'new-video-gallery'); ?>
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-media-code"></span><br />
					<?php esc_html_e('Custom CSS', 'new-video-gallery'); ?>
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-cart"></span><br />
					<?php esc_html_e('Upgrade To Pro', 'new-video-gallery'); ?>
				</a>
			</div>
		</div>

		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bhoechie-tab">
			<div class="bhoechie-tab-content active">
				<h1>
					<?php esc_html_e('ADD Video Banner', 'new-video-gallery'); ?>
				</h1>
				<hr>
				<div id="slider-gallery">
					<h3><span class="dashicons dashicons-editor-help"></span> Tips: <a
							href="https://awplife.com/how-to-get-youtube-video-id/" target="_blank">
							<?php esc_html_e('How to get YouTube / Vimeo video id?', 'new-video-gallery'); ?>
						</a></h3>
					<h3><span class="dashicons dashicons-editor-help"></span> Tips: <a
							href="https://awplife.com/capture-youtube-video-poster/" target="_blank">
							<?php esc_html_e('Capture YouTube / Vimeo Video Poster Like A Pro', 'new-video-gallery'); ?>
						</a></h3>
					<input type="button" id="remove-all-slides" name="remove-all-slides"
						class="button button-large remove-all-slides" rel=""
						value="<?php esc_html_e('Delete All Banner', 'new-video-gallery'); ?>">
					<ul id="remove-slides" class="sbox">
						<?php

						if (isset ($gallery_settings['slide-ids'])) {
							$count = 0;
							foreach ($gallery_settings['slide-ids'] as $id) {
								$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
								$attachment = get_post($id);
								$image_link = $gallery_settings['slide-link'][$count];
								$image_type = $gallery_settings['slide-type'][$count];
								$image_desc = $gallery_settings['slide-desc'][$count];
								$poster_type = $gallery_settings['poster-type'][$count];
								?>
								<li class="slide">
									<img class="new-slide" src="<?php echo esc_url($thumbnail[0]); ?>"
										alt="<?php echo esc_html(get_the_title($id)); ?>"
										style="height: 150px; width: 100%; border-radius: 8px;">
									<input type="hidden" id="slide-ids[]" name="slide-ids[]"
										value="<?php echo esc_html($id); ?>" />
									<!-- Image Title, Caption, Alt Text-->
									<select id="slide-type[]" name="slide-type[]" style="width: 100%;"
										value="<?php echo esc_html($image_type); ?>">
										<option value="y" <?php
										if ($image_type == 'y') {
											echo 'selected=selected';
										}
										?>>
											<?php esc_html_e('YouTube', 'new-video-gallery'); ?>
										</option>
										<option value="v" <?php
										if ($image_type == 'v') {
											echo 'selected=selected';
										}
										?>>
											<?php esc_html_e('Vimeo', 'new-video-gallery'); ?>
										</option>
									</select>
									<input type="text" name="slide-link[]" id="slide-link[]" style="width: 100%;"
										placeholder="Enter YouTube / Vimeo Video ID"
										value="<?php echo esc_html($image_link); ?>">
									<input type="text" name="slide-title[]" id="slide-title[]" style="width: 100%;"
										placeholder="Video Title" value="<?php echo esc_html(get_the_title($id)); ?>">
									<textarea name="slide-desc[]" id="slide-desc[]" placeholder="Video Description"
										style="height: 100px; width: 100%;"><?php echo esc_html($attachment->post_content); ?></textarea>
									<select id="poster-type[]" name="poster-type[]" style="width: 100%;"
										value="<?php echo esc_html($poster_type); ?>">
										<optgroup label="Select Poster Option">
											<option value="internal" <?php
											if ($poster_type == 'internal') {
												echo 'selected';
											}
											?>>
												<?php esc_html_e('Use Above Poster', 'new-video-gallery'); ?>
											</option>
											<option value="youtube" <?php
											if ($poster_type == 'youtube') {
												echo 'selected';
											}
											?>>
												<?php esc_html_e('Fetch YouTube Poster', 'new-video-gallery'); ?>
											</option>
										</optgroup>
									</select>
									<input type="button" name="remove-slide" id="remove-slide"
										class="button remove-single-slide button-danger" style="width: 100%;" value="Delete">
								</li>
								<?php
								$count++;
							} // end of foreach
						} //end of if
						?>
					</ul>
				</div>
				<!--///////=============//////////-->
				<!--YouTube API KEY-->
				<div id="flickr-gallery">
					<div class="row">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h4>
									<?php esc_html_e('YouTube API Key', 'new-video-gallery'); ?>
								</h4>
								<p>
									<?php esc_html_e('Enter YouTube API Key to add the YouTube Video. how to get your API Key - ', 'new-video-gallery'); ?><a
										target="_blank" href="https://www.youtube.com/watch?v=44OBOSBd73M">
										<?php esc_html_e('API Key', 'new-video-gallery'); ?>
									</a>
								</p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field panel-body">
								<?php
								if (isset ($gallery_settings['video_gallery_api_key'])) {
									$video_gallery_api_key = $gallery_settings['video_gallery_api_key'];
								} else {
									$video_gallery_api_key = 'AIzaSyDLlnSIppxQEjiy4Rt5mYJDDHQQI-ynPwQ';
								}
								?>
								<textarea class="form-control" id="video_gallery_api_key"
									name="video_gallery_api_key"><?php echo esc_attr($video_gallery_api_key); ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h4>
									<?php esc_html_e('YouTube Chanel Link', 'animated-live-wall'); ?>
								</h4>
								<p>
									<?php esc_html_e('Enter YouTube Chanel Link - ', 'new-video-gallery'); ?>
								</p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field panel-body">
								<?php
								if (isset ($gallery_settings['video_gallery_channel_link'])) {
									$video_gallery_channel_link = $gallery_settings['video_gallery_channel_link'];
								} else {
									$video_gallery_channel_link = 'https://www.youtube.com/channel/UCqj36njQUT_HCvw6eHzN-hw';
								}
								?>
								<input type="text" class="form-control" id="video_gallery_channel_link"
									name="video_gallery_channel_link"
									value="<?php echo esc_attr($video_gallery_channel_link); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="bhoechie-tab-content no-api-config">
				<h1>
					<?php esc_html_e('Configuration', 'new-video-gallery'); ?>
				</h1>
				<!--Grid-->
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Columns & Thumbnail Settings', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Select gallery thumnails size to display into gallery', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['gal_thumb_size'])) {
								$gal_thumb_size = $gallery_settings['gal_thumb_size'];
							} else {
								$gal_thumb_size = 'full';
							}
							?>
							<select id="gal_thumb_size" name="gal_thumb_size" class="selectbox_settings">
								<option value="thumbnail" <?php
								if ($gal_thumb_size == 'thumbnail') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('Thumbnail – 150 × 150', 'new-video-gallery'); ?>
								</option>
								<option value="medium" <?php
								if ($gal_thumb_size == 'medium') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('Medium – 300 × 169', 'new-video-gallery'); ?>
								</option>
								<option value="large" <?php
								if ($gal_thumb_size == 'large') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('Large – 840 × 473', 'new-video-gallery'); ?>
								</option>
								<option value="full" <?php
								if ($gal_thumb_size == 'full') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('Full Size – 1280 × 720', 'new-video-gallery'); ?>
								</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Colums On Large Desktops', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Select gallery column layout for large desktop devices', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['col_large_desktops'])) {
								$col_large_desktops = $gallery_settings['col_large_desktops'];
							} else {
								$col_large_desktops = 'col-lg-4';
							}
							?>
							<select id="col_large_desktops" name="col_large_desktops" class="selectbox_settings">
								<option value="col-lg-12" <?php
								if ($col_large_desktops == 'col-lg-12') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('1 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-lg-6" <?php
								if ($col_large_desktops == 'col-lg-6') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('2 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-lg-4" <?php
								if ($col_large_desktops == 'col-lg-4') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('3 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-lg-3" <?php
								if ($col_large_desktops == 'col-lg-3') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('4 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-lg-2" <?php
								if ($col_large_desktops == 'col-lg-2') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('6 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-lg-1" <?php
								if ($col_large_desktops == 'col-lg-1') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('12 Column', 'new-video-gallery'); ?>
								</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Colums On Desktops', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Select gallery column layout for desktop devices', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['col_desktops'])) {
								$col_desktops = $gallery_settings['col_desktops'];
							} else {
								$col_desktops = 'col-md-3';
							}
							?>
							<select id="col_desktops" name="col_desktops" class="selectbox_settings">
								<option value="col-md-12" <?php
								if ($col_desktops == 'col-md-12') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('1 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-md-6" <?php
								if ($col_desktops == 'col-md-6') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('2 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-md-4" <?php
								if ($col_desktops == 'col-md-4') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('3 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-md-3" <?php
								if ($col_desktops == 'col-md-3') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('4 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-md-2" <?php
								if ($col_desktops == 'col-md-2') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('6 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-md-1" <?php
								if ($col_desktops == 'col-md-1') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('12 Column', 'new-video-gallery'); ?>
								</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Colums On Tablets', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Select gallery column layout for tablet devices', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['col_tablets'])) {
								$col_tablets = $gallery_settings['col_tablets'];
							} else {
								$col_tablets = 'col-sm-4';
							}
							?>
							<select id="col_tablets" name="col_tablets" class="selectbox_settings">
								<option value="col-sm-12" <?php
								if ($col_tablets == 'col-sm-12') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('1 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-sm-6" <?php
								if ($col_tablets == 'col-sm-12') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('2 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-sm-4" <?php
								if ($col_tablets == 'col-sm-4') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('3 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-sm-3" <?php
								if ($col_tablets == 'col-sm-3') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('4 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-sm-2" <?php
								if ($col_tablets == 'col-sm-2') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('6 Column', 'new-video-gallery'); ?>
								</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Colums On Phones', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Select gallery column layout for phone devices', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['col_phones'])) {
								$col_phones = $gallery_settings['col_phones'];
							} else {
								$col_phones = 'col-xs-6';
							}
							?>
							<select id="col_phones" name="col_phones" class="selectbox_settings">
								<option value="col-xs-12" <?php
								if ($col_phones == 'col-xs-12') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('1 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-xs-6" <?php
								if ($col_phones == 'col-xs-6') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('2 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-xs-4" <?php
								if ($col_phones == 'col-xs-4') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('3 Column', 'new-video-gallery'); ?>
								</option>
								<option value="col-xs-3" <?php
								if ($col_phones == 'col-xs-3') {
									echo 'selected=selected';
								}
								?>>
									<?php esc_html_e('4 Column', 'new-video-gallery'); ?>
								</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e(' Width ', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Set the video frame preview width. Default is 700.', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['width'])) {
								$width = $gallery_settings['width'];
							} else {
								$width = 700;
							}
							?>

							<input type="number" class="selectbox_settings" id="width" name="width" placeholder=""
								value="<?php echo esc_html($width); ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e(' Height Settings', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Set the video frame preview height. Default is 480', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['height'])) {
								$height = $gallery_settings['height'];
							} else {
								$height = 480;
							}
							?>

							<input type="number" class="selectbox_settings" id="height" name="height" placeholder=""
								value="<?php echo esc_html($height); ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Video Icon On Thumbnail', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('You can hide / show Video icon on Thumbnail in gallery', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset ($gallery_settings['video_icon'])) {
									$video_icon = $gallery_settings['video_icon'];
								} else {
									$video_icon = 'false';
								}
								?>
								<input type="radio" class="form-control" id="video_icon1" name="video_icon" value="true"
									<?php
									if ($video_icon == 'true') {
										echo 'checked';
									}
									?>>
								<label for="video_icon1">
									<?php esc_html_e('Yes', 'new-video-gallery'); ?>
								</label>
								<input type="radio" class="form-control" id="video_icon2" name="video_icon"
									value="false" <?php
									if ($video_icon == 'false') {
										echo 'checked';
									}
									?>>
								<label for="video_icon2">
									<?php esc_html_e('No', 'new-video-gallery'); ?>
								</label>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="bhoechie-tab-content no-api-config">
				<h1>
					<?php esc_html_e('Auto play/Close Settings', 'new-video-gallery'); ?>
				</h1>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Auto Play', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Start playback immediately once the element is clicked (true,false)', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset ($gallery_settings['auto_play'])) {
									$auto_play = $gallery_settings['auto_play'];
								} else {
									$auto_play = 'true';
								}
								?>
								<input type="radio" class="form-control" id="auto_play1" name="auto_play" value="true"
									<?php
									if ($auto_play == 'true') {
										echo 'checked';
									}
									?>>
								<label for="auto_play1">
									<?php esc_html_e('Yes', 'new-video-gallery'); ?>
								</label>
								<input type="radio" class="form-control" id="auto_play2" name="auto_play" value="false"
									<?php
									if ($auto_play == 'false') {
										echo 'checked';
									}
									?>>
								<label for="auto_play2">
									<?php esc_html_e('No', 'new-video-gallery'); ?>
								</label>
							</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Auto Close', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('When video will complete than lightbox / popover automatic video is close (true,false)', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset ($gallery_settings['auto_close'])) {
									$auto_close = $gallery_settings['auto_close'];
								} else {
									$auto_close = 'true';
								}
								?>
								<input type="radio" class="form-control" id="auto_close1" name="auto_close" value="true"
									<?php
									if ($auto_close == 'true') {
										echo 'checked';
									}
									?>>
								<label for="auto_close1">
									<?php esc_html_e('Yes', 'new-video-gallery'); ?>
								</label>
								<input type="radio" class="form-control" id="auto_close2" name="auto_close"
									value="false" <?php
									if ($auto_close == 'false') {
										echo 'checked';
									}
									?>>
								<label for="auto_close2">
									<?php esc_html_e('No', 'new-video-gallery'); ?>
								</label>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="bhoechie-tab-content">
				<h1>
					<?php esc_html_e('Extra Other Settings', 'new-video-gallery'); ?>
				</h1>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Z index', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Set the Z-index of video frame preview page overlay. Default is 2100', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4 range-slider switch-field em_size_field">
							<?php
							if (isset ($gallery_settings['z_index'])) {
								$z_index = $gallery_settings['z_index'];
							} else {
								$z_index = 'default';
							}
							if ($z_index == 'default') {
								$z_index_custom_value = 2100;
							} else {
								if (isset ($gallery_settings['z_index_custom_value'])) {
									$z_index_custom_value = $gallery_settings['z_index_custom_value'];
								} else {
									$z_index_custom_value = 2100;
								}
							}
							?>

							<input type="radio" class="form-control" id="z_index1" name="z_index" value="default" <?php
							if ($z_index == 'default') {
								echo 'checked';
							}
							?>>
							<label for="z_index1">
								<?php esc_html_e('Default', 'new-video-gallery'); ?>
							</label>
							<input type="radio" class="form-control" id="z_index2" name="z_index" value="custom" <?php
							if ($z_index == 'custom') {
								echo 'checked';
							}
							?>>
							<label for="z_index2">
								<?php esc_html_e('Custom', 'new-video-gallery'); ?>
							</label>
							<br><br><br>
							<input id="z_index_custom_value" name="z_index_custom_value" class="range-slider__range"
								type="range" value="<?php echo esc_html($z_index_custom_value); ?>" min="0" max="9999"
								step="10" style="width: 300px !important; margin-left: 10px;">
							<span class="range-slider__value">0</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>
								<?php esc_html_e('Custom CSS', 'new-video-gallery'); ?>
							</h4>
							<p>
								<?php esc_html_e('Apply own css on video gallery and dont use style tag', 'new-video-gallery'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<?php
							if (isset ($gallery_settings['custom_css'])) {
								$custom_css = $gallery_settings['custom_css'];
							} else {
								$custom_css = '';
							}
							?>
							<textarea name="custom_css" id="custom_css" style="width: 100%; height: 120px;"
								placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo esc_html($custom_css); ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="bhoechie-tab-content">
				<h1>
					<?php esc_html_e('Upgrade To Pro', 'new-video-gallery'); ?>
				</h1>
				<hr>
				<!--Grid-->
				<div class="" style="padding-left: 10px;">
					<p class="ms-title">Upgrade To Premium For Unloack More Features & Settings</p>
				</div>

				<div class="">
					<h1><strong>Offer:</strong> Upgrade To Premium Just In Half Price <strike>$49.99</strike>
						<strong>$25</strong></h1>
					<br>
					<a href="https://awplife.com/wordpress-plugins/video-gallery-wordpress-plugin/" target="_blank"
						class="button button-primary button-hero load-customize hide-if-no-customize">Premium Version
						Details</a>
					<a href="https://awplife.com/demo/video-gallery-premium/" target="_blank"
						class="button button-primary button-hero load-customize hide-if-no-customize">Check Live
						Demo</a>
					<a href="https://awplife.com/demo/video-gallery-premium-admin-demo/" target="_blank"
						class="button button-primary button-hero load-customize hide-if-no-customize">Try Pro
						Version</a>
				</div>

			</div>
		</div>
	</div>
</div>

<input type="hidden" name="vg-settings" id="vg-settings" value="vg-save-settings">
<?php
// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
wp_nonce_field('vg_save_settings', 'vg_save_nonce');
?>
<style>
	#edit-slug-box {
		display: none;
	}

	.col-1,
	.col-2,
	.col-3,
	.col-4,
	.col-5,
	.col-6,
	.col-7,
	.col-8,
	.col-9,
	.col-10,
	.col-11,
	.col-12,
	.col,
	.col-auto,
	.col-sm-1,
	.col-sm-2,
	.col-sm-3,
	.col-sm-4,
	.col-sm-5,
	.col-sm-6,
	.col-sm-7,
	.col-sm-8,
	.col-sm-9,
	.col-sm-10,
	.col-sm-11,
	.col-sm-12,
	.col-sm,
	.col-sm-auto,
	.col-md-1,
	.col-md-2,
	.col-md-3,
	.col-md-4,
	.col-md-5,
	.col-md-6,
	.col-md-7,
	.col-md-8,
	.col-md-9,
	.col-md-10,
	.col-md-11,
	.col-md-12,
	.col-md,
	.col-md-auto,
	.col-lg-1,
	.col-lg-2,
	.col-lg-3,
	.col-lg-4,
	.col-lg-5,
	.col-lg-6,
	.col-lg-7,
	.col-lg-8,
	.col-lg-9,
	.col-lg-10,
	.col-lg-11,
	.col-lg-12,
	.col-lg,
	.col-lg-auto,
	.col-xl-1,
	.col-xl-2,
	.col-xl-3,
	.col-xl-4,
	.col-xl-5,
	.col-xl-6,
	.col-xl-7,
	.col-xl-8,
	.col-xl-9,
	.col-xl-10,
	.col-xl-11,
	.col-xl-12,
	.col-xl,
	.col-xl-auto {
		float: left;
	}

	.selectbox_settings {
		width: 300px;
		margin-left: 20px;
	}
</style>


<script>
	var video_gallery_option = jQuery('[name=video_gallery_option]:checked').val();
	if (video_gallery_option == 'no_api') {
		jQuery('.no_api').addClass("tab-active");
		jQuery("div.video_yoyube_api").removeClass("tab-active");
		jQuery('.video-gallery-content').css("display", "block");
		jQuery('#slider-gallery').css("display", "block");
		jQuery('#flickr-gallery').css("display", "none");
		jQuery('.no-api-config').css("display", "block");
		jQuery('.api-yes-config-setting').css("display", "none");
	}

	if (video_gallery_option == 'video_yoyube_api') {
		jQuery('.video_yoyube_api').addClass("tab-active");
		jQuery("div.no_api").removeClass("tab-active");
		jQuery('.video-gallery-content').css("display", "none");
		jQuery('#slider-gallery').css("display", "none");
		jQuery('.no-api-config').css("display", "none");
		jQuery('#flickr-gallery').css("display", "block");
		jQuery('.api-yes-config-setting').css("display", "block");
	}

	// title size range settings.  on change range value
	function updateRange(val, id) {
		jQuery("#" + id).val(val);
		jQuery("#" + id + "_value").val(val);
	}

	// start pulse on page load
	function pulseEff() {
		jQuery('#shortcode').fadeOut(600).fadeIn(600);
	};
	var Interval;
	Interval = setInterval(pulseEff, 1500);

	// stop pulse
	function pulseOff() {
		clearInterval(Interval);
	}
	// start pulse
	function pulseStart() {
		Interval = setInterval(pulseEff, 2000);
	}

	///on load zinx hide show
	var zindex = jQuery('input[name="z_index"]:checked').val();
	if (zindex == "default") {
		jQuery("#z_index_custom").val(2100);
		jQuery("#z_index_custom_value").val(2100);
	}

	// description font size hide show
	jQuery(document).ready(function () {
		jQuery('#z_index').change(function () {
			var zindex = jQuery('input[name="z_index"]:checked').val();
			if (zindex == "default") {
				jQuery("#z_index_custom").val(2100);
				jQuery("#z_index_custom_value").val(2100);
			}
		});
	});

	//new editing setting page Start .....
	//dropdown toggle on change effect
	jQuery(document).ready(function () {
		//accordion icon
		jQuery(function () {
			function toggleSign(e) {
				jQuery(e.target)
					.prev('.panel-heading')
					.find('i')
					.toggleClass('fa fa-chevron-down fa fa-chevron-up');
			}
			jQuery('#accordion').on('hidden.bs.collapse', toggleSign);
			jQuery('#accordion').on('shown.bs.collapse', toggleSign);

		});
	});

	//range slider
	var rangeSlider = function () {
		var slider = jQuery('.range-slider'),
			range = jQuery('.range-slider__range'),
			value = jQuery('.range-slider__value');

		slider.each(function () {

			value.each(function () {
				var value = jQuery(this).prev().attr('value');
				jQuery(this).html(value);
			});

			range.on('input', function () {
				jQuery(this).next(value).html(this.value);
			});
		});
	};
	rangeSlider();
	//new editing setting page end....

	jQuery('input[type=radio][name=video_gallery_option]').change(function () {
		var video_gallery_option = jQuery('[name=video_gallery_option]:checked').val();
		if (video_gallery_option == 'no_api') {
			jQuery('.no_api').addClass("tab-active");
			jQuery("div.video_yoyube_api").removeClass("tab-active");
			jQuery('.video-gallery-content').css("display", "block");
			jQuery('#slider-gallery').css("display", "block");
			jQuery('#flickr-gallery').css("display", "none");
			jQuery('.api-yes-config-setting').css("display", "none");
			jQuery('.no-api-config').css("display", "block");
		}

		if (video_gallery_option == 'video_yoyube_api') {
			jQuery('.video_yoyube_api').addClass("tab-active");
			jQuery("div.no_api").removeClass("tab-active");
			jQuery('.video-gallery-content').css("display", "none");
			jQuery('#slider-gallery').css("display", "none");
			jQuery('#flickr-gallery').css("display", "block");
			jQuery('.no-api-config').css("display", "none");
			jQuery('.api-yes-config-setting').css("display", "block");
		}

	});

	// tab
	jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
		e.preventDefault();
		jQuery(this).siblings('a.active').removeClass("active");
		jQuery(this).addClass("active");
		var index = jQuery(this).index();
		jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
		jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
	});	
</script>