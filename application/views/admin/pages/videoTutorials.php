
	<div class="container multi-lang-page">

		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-header py-3 d-flex justify-content-between title-bar">
				<h1 class="h4 text-gray-900 mb-0"><?= $this->lang->line("Video")?> <?= $this->lang->line("Tutorial")?></h1>
				<div class="lang-bar">
					<span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
					<span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
					<span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
				</div>
			</div>
			<div class="card-body p-0">
				<!-- Nested Row within Card Body -->
				<div class="row">
			 
					<div class="col-lg-12">
						<div class="p-sm-5 p-3">
							<form id="videoTutorialsForm">
								<div class="row mb-4">
									<div class="col-md-4 update-video text-center">
										<input type="file" class="dropify" name="video" />
									</div>
									<div class="col-md-8">
										<div class="input-group english-field hide-field video_description-editor lang-field">
											<div class="input-group-prepend">
												<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/en-flag.png')?>" ></span>
											</div>
											<textarea class="summernote form-control" name="video_description_english" data-plugin-options='{ "height": 200}'></textarea>
										</div>
										<div class="input-group french-field hide-field video_description-editor lang-field">
											<div class="input-group-prepend">
												<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/fr-flag.png')?>" ></span>
											</div>
											<textarea class="summernote form-control" name="video_description_french"></textarea>
										</div>
										<div class="input-group germany-field hide-field video_description-editor lang-field">
											<div class="input-group-prepend">
												<span class="input-group-text"><img class="img-profile rounded-circle active-flag" src="<?= base_url('assets/flags/ge-flag.png')?>" ></span>
											</div>
											<textarea class="summernote form-control" name="video_description_germany" ></textarea>
										</div>
									</div>
								</div>
								<div>
									<div class="progress video-upload-status-bar mb-4  hide-field">
										<div class="progress-bar bg-pink progress-bar-striped progress-bar-animated video-upload-status" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
											<span class="sr-only">0% Complete</span>
										</div>
									</div>
								</div>
								<input type="submit" name="" value="Update" class="btn btn-primary btn-block">
							</form>
							<?php
								function show_limit_str($str,$length = 10){
									if( strlen( $str ) > $length ) {
										$str = substr( $str, 0, $length ) . '...';
									}
									return $str;
								}
								foreach ($video_tutorials as $vkey => $video_tutorial) {
								?>
									<div class="video-wrapper  my-4 p-2 p-md-4">
										<div class="row">
											<div class="col-md-4 update-video text-center">
												<?php
													if (isset($video_tutorial->video_url) && $video_tutorial->video_url !== ""){
														$video_url = base_url("/assets/video_tutorials/").$video_tutorial->video_url;
													}else{
														$video_url = "";
													}
												?>
												<video width="100%" height="auto" controls>
													<source src="<?= $video_url?>">
												</video>
												<div class="ctr-board">
													<a class="remove_video_tutorial btn btn-danger text-white px-4" d-video_id ="<?= $video_tutorial->video_id ?>"><?= $this->lang->line("Remove")?></a>
													<a class="edit_video_tutorial btn btn-success text-white px-4" href="<?= base_url("Admin/videoTutorialDetail/").$video_tutorial->video_id  ?>"><?= $this->lang->line("Edit")?></a>
												</div>
											</div>
											<div class="col-md-8 mt-3 mt-sm-0">
												<div class="english-field hide-field video_description lang-field">
													<div><?= isset($video_tutorial) ? show_limit_str($video_tutorial->video_description_english,570) : ""?></div>
												</div>
												<div class="french-field hide-field video_description lang-field">
													<div><?= isset($video_tutorial) ? show_limit_str($video_tutorial->video_description_french,570) : ""?></div>
												</div>
												<div class="germany-field hide-field video_description lang-field">
													<div><?= isset($video_tutorial) ? show_limit_str($video_tutorial->video_description_germany,570) : ""?></div>
												</div>
											</div>
										</div>
									</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	
