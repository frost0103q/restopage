
	<div class="container multi-lang-page">

		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<!-- Nested Row within Card Body -->
				<div class="row">
			 
					<div class="col-lg-12">
						<div class="p-2 p-sm-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4"><?= $this->lang->line("Free Support")?></h1>
								<hr>
							</div>
							<form class="user" id="adminFreeSupport">
								<div class="admin-info">
									<label><?= $this->lang->line("Admin")?> <?= $this->lang->line("Email")?></label>
									<div class="form-group row">
										<div class="col-9 mb-3">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-envelope"></i></span>
												</div>
												<input type="email" class="form-control" id="admin_contact_email" placeholder="admin@email.com" name="admin_contact_email" value="<?= $admin->admin_contact_email?>">
											</div>
										</div>
										<div class="col-3 mb-3 d-flex align-items-center justify-content-end">
											<input type="checkbox" data-plugin="switchery" data-color="#3DDCF7" name="is_show_admin_contact_email"  <?= isset($admin->admin_is_contact_email) && $admin->admin_is_contact_email == 1 ? "checked" : "" ?>>
										</div>
									</div>
								</div>
								<div class="admin-info">
									<label><?= $this->lang->line("Admin")?> <?= $this->lang->line("Fax")?></label>
									<div class="form-group row">
										<div class="col-9 mb-3">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-fax"></i></span>
												</div>
												<input type="text" class="form-control" id="admin_fax" placeholder="000-000-0000" name="admin_fax" value="<?= $admin->admin_fax?>">
											</div>
										</div>
										<div class="col-3 mb-3 d-flex align-items-center justify-content-end">
											<input type="checkbox" data-plugin="switchery" data-color="#3DDCF7" name="is_show_admin_fax" <?= isset($admin->admin_is_fax) && $admin->admin_is_fax == 1 ? "checked" : "" ?>>
										</div>
									</div>
								</div>
								<div class="admin-info">
									<label><?= $this->lang->line("Admin")?> <?= $this->lang->line("Phone")?></label>
									<div class="form-group row">
										<div class="col-9 mb-3">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-phone"></i></span>
												</div>
												<input type="text" class="form-control" id="admin_phone" placeholder="+352 800-26-735" name="admin_phone" value="<?= $admin->admin_phone?>">
											</div>
										</div>
										<div class="col-3 mb-3 d-flex align-items-center justify-content-end">
											<input type="checkbox" data-plugin="switchery" data-color="#3DDCF7" name="is_show_admin_phone" <?= isset($admin->admin_is_phone) && $admin->admin_is_phone == 1 ? "checked" : "" ?>>
										</div>
									</div>
								</div>
								<div class="admin-info">
									<label><?= $this->lang->line("Admin")?> Whatsapp</label>
									<div class="form-group row">
										<div class="col-9 mb-3">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-phone-square"></i></span>
												</div>
												<input type="text" class="form-control" id="admin_whatsapp" name="admin_whatsapp" value="<?= $admin->admin_whatsapp?>">
											</div>
										</div>
										<div class="col-3 mb-3 d-flex align-items-center justify-content-end">
											<input type="checkbox" data-plugin="switchery" data-color="#3DDCF7" name="is_show_admin_whatsapp" <?= isset($admin->admin_is_whatsapp) && $admin->admin_is_whatsapp == 1 ? "checked" : "" ?>>
										</div>
									</div>
								</div>
								<hr>
								<div class="admin-info multi-lang">
									<label class="d-flex justify-content-between"><?= $this->lang->line("Admin")?> <?= $this->lang->line("Other Info")?>
										<div class="lang-bar">
											<span class="<?= $_lang == 'english' ? 'active' : ''  ?> item-flag" data-flag="english"><img class="english-flag" src="<?= base_url('assets/flags/en-flag.png')?>"></span>
											<span class="<?= $_lang == 'french' ? 'active' : ''  ?> item-flag" data-flag="french"><img class="french-flag" src="<?= base_url('assets/flags/fr-flag.png')?>"></span>
											<span class="<?= $_lang == 'germany' ? 'active' : ''  ?> item-flag" data-flag="germany"><img class="germany-flag" src="<?= base_url('assets/flags/ge-flag.png')?>"></span>
										</div>
									</label>
									
									<div class="form-group row">
										<div class="col-9 mb-3">
											<div class="input-group english-field hide-field lang-field">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-info-circle"></i></span>
												</div>
												<textarea class="summernote form-control" id="admin_other_info_english"  name="admin_other_info_english"><?= $admin->admin_other_info_english?></textarea>
											</div>
											<div class="input-group germany-field hide-field lang-field">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-info-circle"></i></span>
												</div>
												<textarea class="summernote form-control" id="admin_other_info_germany"  name="admin_other_info_germany"><?= $admin->admin_other_info_germany?></textarea>
											</div>
											<div class="input-group french-field hide-field lang-field">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-info-circle"></i></span>
												</div>
												<textarea class="summernote form-control" id="admin_other_info_french"  name="admin_other_info_french"><?= $admin->admin_other_info_french?></textarea>
											</div>
										</div>
										<div class="col-3 mb-3 d-flex align-items-center justify-content-end">
											<input type="checkbox" data-plugin="switchery" data-color="#3DDCF7" name="is_show_admin_other_info" <?= isset($admin->admin_is_other_info) && $admin->admin_is_other_info == 1 ? "checked" : "" ?>>
										</div>
									</div>
								</div>
								<input type="submit" name="" value="<?= $this->lang->line("SAVE") ?>" class="btn btn-primary btn-user btn-block">
							</form>
							<hr>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	
