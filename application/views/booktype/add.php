<div class="content-wrapper">
    <section class="content-header">
  		<h1><?=$this->lang->line('booktype')?></h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
  			<li><a href="<?=base_url('booktype/index')?>"><?=$this->lang->line('booktype')?></a></li>
  			<li class="active"><?=$this->lang->line('add')?></li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('name') ? 'has-error' : ''?>">
							 	<label for="name"><?=$this->lang->line('booktype_name')?></label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="name" name="name" value="<?=set_value('name')?>" placeholder="Enter name">
							  	<?=form_error('name')?>
							</div>
							<div class="form-group <?=form_error('description') ? 'has-error' : ''?>">
							  	<label for="description"><?=$this->lang->line('booktype_description')?></label> <span class="text-red">*</span>
							  	<textarea name="description" value="<?=set_value('description')?>" id="" cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('description')?></textarea>
							  	<?=form_error('description')?>
							</div>
							<div class="form-group <?=form_error('bookissue_type') ? 'has-error' : ''?>">
							  	<label for="bookissue_type"><?=$this->lang->line('booktype_bookissue_type')?></label>
								  <!-- <span class="text-red"></span> -->
							  	<?php 
									$bookissue_typeArray[0] = $this->lang->line('booktype_please_select');
									$bookissue_typeArray[1] = $this->lang->line('booktype_bookissue_libraryconfig');
									$bookissue_typeArray[2] = $this->lang->line('booktype_bookissue_fixdate');

									echo form_dropdown('bookissue_type', $bookissue_typeArray, set_value('bookissue_type'),'id="bookissue_type" required class="form-control"');
								?>
							  	<?=form_error('bookissue_type')?>
							</div>
							<div id="form_fixdate" class="form-group <?=form_error('bookissue_date') ? 'has-error' : ''?>" <?=form_error('bookissue_date') ? '' : 'style="display: none;'?> >
							 	<label for="bookissue_date"><?=$this->lang->line('bookissue_date')?></label><span class="text-red">*</span>
							  	<input type="text" class="form-control datepicker" id="bookissue_date" name="bookissue_date" value="<?=set_value('bookissue_date')?>" placeholder="Enter book issue date">
							  	<?=form_error('bookissue_date')?>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-mytheme"><?=$this->lang->line('booktype_add_booktype')?></button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<script>
			$('#bookissue_type').change(function(e){
				var val = $(this).val();
				if (val == 2) {
					$('#form_fixdate').slideDown();
				} else {
					$('#form_fixdate').slideUp();
				}
			});

			$(".datepicker").datepicker({
				format : 'dd-mm',
			}).on('show', function() {
				// remove the year from the date title before the datepicker show
					var dateText  = $(".datepicker-days .datepicker-switch").text().split(" ");
					var dateTitle = dateText[0];
					$(".datepicker-days .datepicker-switch").text(dateTitle);
					$(".datepicker-months .datepicker-switch").css({"visibility":"hidden"});
			});
		</script>

    </section>
</div>