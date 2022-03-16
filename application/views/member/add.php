<div class="content-wrapper">
    <section class="content-header">
  		<h1><?=$this->lang->line('member')?></h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
  			<li><a href="<?=base_url('member/index')?>"><?=$this->lang->line('member')?></a></li>
  			<li class="active"><?=$this->lang->line('add')?></li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('firstname') ? 'has-error' : ''?>">
							 	<label for="firstname"><?=$this->lang->line('member_firstname')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="firstname" name="firstname" value="<?=set_value('firstname')?>" placeholder="Enter firstname">
							  	<?=form_error('firstname')?>
							</div>
							<div class="form-group <?=form_error('lastname') ? 'has-error' : ''?>">
							 	<label for="lastname"><?=$this->lang->line('member_lastname')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="lastname" name="lastname" value="<?=set_value('lastname')?>" placeholder="Enter lastname">
							  	<?=form_error('lastname')?>
							</div>
							<div class="form-group <?=form_error('dateofbirth') ? 'has-error' : ''?>">
								<label for="dateofbirth"><?=$this->lang->line('member_date_of_birth')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control datepicker" id="dateofbirth" name="dateofbirth" value="<?=set_value('dateofbirth')?>" placeholder="Enter date of birth">
							  	<?=form_error('dateofbirth')?>
							</div>
							<div class="form-group <?=form_error('placeofbirth') ? 'has-error' : ''?>">
							  	<label for="placeofbirth"><?=$this->lang->line('member_place_birth')?></label>
							  	<input name="placeofbirth" value="<?=set_value('placeofbirth')?>" id="" cols="30" rows="5" class="form-control" placeholder="Enter placeofbirth"><?=set_value('placeofbirth')?>
							  	<?=form_error('placeofbirth')?>
							</div>
							<div class="form-group <?=form_error('gender') ? 'has-error' : ''?>">
							  	<label><?=$this->lang->line('member_gender')?></label> <span class="text-red">*</span>
							  	<?php 
									$genderArray[0]        = $this->lang->line('member_please_select');
									$genderArray['Male']   = $this->lang->line('member_male');
									$genderArray['Female'] = $this->lang->line('member_female');

									echo form_dropdown('gender', $genderArray, set_value('gender'),'id="gender" class="form-control"');
								?>
							  	<?=form_error('gender')?>
							</div>
							<div class="form-group <?=form_error('email') ? 'has-error' : ''?>">
							  	<label for="email"><?=$this->lang->line('member_email')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="email" name="email" value="<?=set_value('email')?>" placeholder="Enter email">
							  	<?=form_error('email')?>
							</div>
							<div class="form-group <?=form_error('phone') ? 'has-error' : ''?>">
							  	<label for="phone"><?=$this->lang->line('member_phone')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone')?>" placeholder="Enter phone">
							  	<?=form_error('phone')?>
							</div>
							<div class="form-group <?=form_error('address') ? 'has-error' : ''?>">
							  	<label for="address"><?=$this->lang->line('member_address')?></label>
							  	<textarea name="address" value="<?=set_value('address')?>" id="" cols="30" rows="5" class="form-control" placeholder="Enter address"><?=set_value('address')?></textarea>
							  	<?=form_error('address')?>
							</div>
							<div class="form-group <?=form_error('photo') ? 'has-error' : ''?>">
						        <label for="photo"><?=$this->lang->line("member_photo")?></label>
						        <div class="input-group image-preview">
						            <input type="text" class="form-control image-preview-filename" disabled="disabled">
						            <span class="input-group-btn">
						                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
						                    <span class="fa fa-remove"></span><?=$this->lang->line('member_clear')?>
						                </button>
						                <div class="btn btn-success image-preview-input">
						                    <span class="fa fa-repeat"></span>
						                    <span class="image-preview-input-title"><?=$this->lang->line('member_filebrowse')?></span>
						                    <input type="file" accept="image/png, image/jpeg, image/gif" name="photo"/>
						                </div>
						            </span>
						        </div>
						      	<?=form_error('photo');?>
						    </div>
							<div class="form-group <?=form_error('roleID') ? 'has-error' : ''?>">
							  	<label for="roleID"><?=$this->lang->line('member_role')?></label> <span class="text-red">*</span>
								<?php 
									$roleArray[0] = $this->lang->line('member_please_select');
									if(calculate($roles)) {
										foreach ($roles as $role) {
											$roleArray[$role->roleID] = $role->role;
										}
									}
									echo form_dropdown('roleID', $roleArray,set_value('roleID'),'id="roleID" class="form-control"');
								?>
								<?=form_error('roleID')?>
							</div>
							<div class="form-group <?=form_error('classeID') ? 'has-error' : ''?>">
							  	<label for="classeID"><?=$this->lang->line('member_classe')?></label>
								<?php 
									$classeArray[0] = $this->lang->line('member_please_select');
									if(calculate($classes)) {
										foreach ($classes as $classe) {
											$classeArray[$classe->classeID] = $classe->classe;
										}
									}
									echo form_dropdown('classeID', $classeArray,set_value('classeID'),'id="classeID" class="form-control"');
								?>
								<?=form_error('classeID')?>
							</div>
							<div class="form-group <?=form_error('class_group') ? 'has-error' : ''?>">
							  	<label for="class_group"><?=$this->lang->line('member_class_group')?></label>
								  <?php 
									$class_groupArray[0] = $this->lang->line('member_please_select');
									$class_groupArray['A'] = 'A';
									$class_groupArray['B'] = 'B';
									$class_groupArray['C'] = 'C';
									$class_groupArray['D'] = 'D';

									echo form_dropdown('class_group', $class_groupArray, set_value('class_group'),'id="class_group" class="form-control"');
								?>							  	
								  	<?=form_error('class_group')?>
							</div>
							<div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
							  	<label for="status"><?=$this->lang->line('member_status')?></label> <span class="text-red">*</span>
							  	<?php 
									$statusArray[0] = $this->lang->line('member_please_select');
									$statusArray[1] = $this->lang->line('member_active');
									$statusArray[2] = $this->lang->line('member_block');

									echo form_dropdown('status', $statusArray, set_value('status'),'id="status" class="form-control"');
								?>
							  	<?=form_error('status')?>
							</div>
							<div class="form-group <?=form_error('username') ? 'has-error' : ''?>">
							  	<label for="username"><?=$this->lang->line('member_username')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="username" name="username" value="<?=set_value('username')?>" placeholder="Enter username">
							  	<?=form_error('username')?>
							</div>
							<div class="form-group <?=form_error('password') ? 'has-error' : ''?>">
							  	<label for="password"><?=$this->lang->line('member_password')?></label> <span class="text-red">*</span>
							  	<div class="input-group">
							    	<input type="password" class="form-control" id="password" name="password" value="<?=set_value('password')?>" placeholder="Enter Password">
							    	<span style="cursor: pointer;" class="input-group-addon" id="generate_password"><i class="fa fa-repeat"></i></span>
							    	<span style="cursor: pointer;" class="input-group-addon" id="showpassword"><i class="fa fa-eye" id="eyeicon"></i></span>
							  	</div>
							  	<?=form_error('password')?>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-mytheme"><?=$this->lang->line('member_add_member')?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </section>
</div>