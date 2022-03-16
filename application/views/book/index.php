<div class="content-wrapper">
    <section class="content-header">
		<h1><?=$this->lang->line('book')?></h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
			<li class="active"><?=$this->lang->line('book')?></li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('book_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('book/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> <?=$this->lang->line('book_add_book')?></a>
                <a href="#" data-toggle="modal" data-target="#import" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-upload"></i> <?=$this->lang->line('book_import_book')?></a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?=$this->lang->line('book_slno')?></th>
                                <th><?=$this->lang->line('book_cover_photo')?></th>
                                <th><?=$this->lang->line('book_name')?></th>
                                <th><?=$this->lang->line('book_author')?></th>
                                <th><?=$this->lang->line('book_quantity')?></th>
                                <th><?=$this->lang->line('book_volume')?></th>
                                <th><?=$this->lang->line('book_code_no')?></th>
                                <?php if(permissionChecker('book_edit') || permissionChecker('book_delete')) { ?>
                                    <th><?=$this->lang->line('book_action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($books)) { $i=0; foreach($books as $book) { $i++; ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('book_slno')?>"><?=$i?></td>
                                    <td data-title="<?=$this->lang->line('book_cover_photo')?>"><img src="<?=app_image_link($book->coverphoto,'uploads/book/','book.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="<?=$this->lang->line('book_name')?>"><?=$book->name?></td>
                                    <td data-title="<?=$this->lang->line('book_author')?>"><?=$book->author?></td>
                                    <td data-title="<?=$this->lang->line('book_quantity')?>"><?=$book->quantity?></td>
                                    <td data-title="<?=$this->lang->line('book_volume')?>"><?=$book->volume?></td>
                                    <td data-title="<?=$this->lang->line('book_code_no')?>"><?=$book->codeno?></td>
                                    <?php if(permissionChecker('book_edit') || permissionChecker('book_delete')) { ?>
                                        <td data-title="<?=$this->lang->line('book_action')?>">
                                            <?=btn_view('book/view/'.$book->bookID,$this->lang->line('book_view')); ?>
                                            <?php if($book->deleted_at == 0) {
                                                echo btn_edit('book/edit/'.$book->bookID,$this->lang->line('book_edit')). " ";
                                                echo btn_delete('book/delete/'.$book->bookID,$this->lang->line('book_delete'));
                                            } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?=$this->lang->line('book_slno')?></th>
                                <th><?=$this->lang->line('book_cover_photo')?></th>
                                <th><?=$this->lang->line('book_name')?></th>
                                <th><?=$this->lang->line('book_author')?></th>
                                <th><?=$this->lang->line('book_quantity')?></th>
                                <th><?=$this->lang->line('book_volume')?></th>
                                <th><?=$this->lang->line('book_code_no')?></th>
                                <?php if(permissionChecker('book_edit') || permissionChecker('book_delete')) { ?>    
                                    <th><?=$this->lang->line('book_action')?></th>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
          </div>

          <!-- Import -->
          <div id="import" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$this->lang->line('book_import_book')?></h4>
                </div>
                <form action="<?=base_url('book/import')?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group <?=form_error('book_import') ? 'has-error' : ''?>">
                        <label for="book_import"> <?=$this->lang->line("book_import_file")?> <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="File types: xlxs, xlx, csv"></i></label>
                        <div class="input-group image-preview">
                            <input type="text" class="form-control fileuploadname" value="" disabled="disabled" />
                            <span class="input-group-btn">
                                <div class="btn btn-success image-preview-input">
                                    <span class="fa fa-repeat"></span>
                                    <span class="image-preview-input-title"><?=$this->lang->line('book_import_file')?></span>
                                    <input type="file" name="fileupload" accept=".xlsx, .xls, .csv" id="fileupload" required/>
                                </div>
                            </span>
                        </div>
                        <?=form_error('book_import');?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a target="_blank" href="<?=base_url('uploads/book/books.xlsx')?>" class="btn btn-inline btn-mytheme btn-md"><?=$this->lang->line('book_import_template')?></a>
                    <button type="submit" value="submit" name="submit" class="btn btn-inline btn-mytheme btn-md"><?=$this->lang->line('book_import')?></button>
                </div>
                </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
          <!-- Import -->
    </section>
</div>