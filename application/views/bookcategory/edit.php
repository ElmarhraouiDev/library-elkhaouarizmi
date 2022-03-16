<div class="content-wrapper">
    <section class="content-header">
  		<h1><?=$this->lang->line('bookcategory')?></h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
  			<li><a href="<?=base_url('bookcategory/index')?>"><?=$this->lang->line('bookcategory')?></a></li>
  			<li class="active"><?=$this->lang->line('edit')?></li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('id_code') ? 'has-error' : ''?>">
							 	<label for="id_code"><?=$this->lang->line('bookcategory_id_code')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="id_code" name="id_code" value="<?=set_value('id_code', $bookcategory->id_code)?>" placeholder="Enter ID">
							  	<?=form_error('id_code')?>
							</div>
							<div class="form-group <?=form_error('name') ? 'has-error' : ''?>">
							 	<label for="name"><?=$this->lang->line('bookcategory_name')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="name" name="name" value="<?=set_value('name', $bookcategory->name)?>" placeholder="Enter name">
							  	<?=form_error('name')?>
							</div>
							<div class="form-group <?=form_error('description') ? 'has-error' : ''?>">
							  	<label for="description"><?=$this->lang->line('bookcategory_description')?></label> <span class="text-red">*</span>
							  	<textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('description', $bookcategory->description)?></textarea>
							  	<?=form_error('description')?>
							</div>
							<div class="form-group <?=form_error('coverphoto') ? 'has-error' : ''?>">
						        <label for="coverphoto"><?=$this->lang->line("bookcategory_coverphoto")?></label>
						        <div class="input-group image-preview">
						            <input type="text" class="form-control image-preview-filename" disabled="disabled">
						            <span class="input-group-btn">
						                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
						                    <span class="fa fa-remove"></span><?=$this->lang->line('bookcategory_clear')?>
						                </button>
						                <div class="btn btn-success image-preview-input">
						                    <span class="fa fa-repeat"></span>
						                    <span class="image-preview-input-title"><?=$this->lang->line('bookcategory_filebrowse')?></span>
						                    <input type="file" accept="image/png, image/jpeg, image/gif" name="coverphoto"/>
						                </div>
						            </span>
						        </div>
						        <div class="input-group">
						        	<img class="userprofileimg" src="<?=app_image_link($bookcategory->coverphoto,'uploads/bookcategory/','bookcategory.jpg')?>" alt="">
						        </div>
						      	<?=form_error('coverphoto');?>
						    </div>
							<div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
							  	<label for="status"><?=$this->lang->line('bookcategory_status')?></label> <span class="text-red">*</span>
							  	<?php 
									$statusArray[0] = $this->lang->line('bookcategory_please_select');
									$statusArray[1] = $this->lang->line('bookcategory_enable');
									$statusArray[2] = $this->lang->line('bookcategory_disable');

									echo form_dropdown('status', $statusArray, set_value('status', $bookcategory->status),'id="status" class="form-control"');
								?>
							  	<?=form_error('status')?>
							</div>
							<div class="form-group <?=form_error('parent_catagory') ? 'has-error' : ''?>">
							  	<label for="parent_catagory"><?=$this->lang->line('bookcategory_parent_catagory')?></label> <span class="text-red"></span>
							  	<?php 

									$parent_catagory = array();
									$parent_catagory_order = array();
									$parent_catagory_ids = array();
									
									foreach($bookcategory_all as $catagory) {
										$index = array_search($catagory->parent_catagory, $parent_catagory_ids) ? array_search($catagory->parent_catagory, $parent_catagory_ids) : 0; 
										$inserted = $catagory->bookcategoryID; 
										array_splice($parent_catagory_ids, $index, 0, $inserted);
										$str = generateString('&nbsp&nbsp&nbsp', $catagory->level_in_catagory) . $catagory->name;
										if ($catagory->level_in_catagory == '0') {
												$str .= '{bold}';
										}
										$parent_catagory[$catagory->bookcategoryID] = $str;
									}

									foreach($parent_catagory_ids as $catagory_id) {
										$parent_catagory_order[$catagory_id] = $parent_catagory[$catagory_id] ;
									}
									$parent_catagory_order['-1'] = '--' ;
									$parent_catagory_order = array_reverse($parent_catagory_order, true);

									echo form_dropdown('parent_catagory', $parent_catagory_order, set_value('parent_catagory', $bookcategory->parent_catagory),'id="parent_catagory" class="form-control"');
								?>
							  	<?=form_error('parent_catagory')?>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-mytheme"><?=$this->lang->line('bookcategory_update_book_category')?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </section>
</div>