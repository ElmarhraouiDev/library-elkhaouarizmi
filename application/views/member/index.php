<div class="content-wrapper">
    <section class="content-header">
		<h1><?=$this->lang->line('member')?></h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('member')?></li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('member_add')) { ?>
                <div class="box-header">
                    <div>
                    <form action="<?=base_url('member/import2')?>" method="post" onsubmit="import2()" enctype="multipart/form-data">
                        <input type="file" name="fileupload" accept=".xlsx, .xls, .csv" id="fileupload2"  required/>
                           <button type="submit" value="submit" name="submit" class="btn btn-inline btn-mytheme btn-md"><?=$this->lang->line('member_import')?></button>
                    </form>
                    </div>
                    <a style="margin-right: 5px;" href="<?=base_url('member/add')?>" class="btn btn-inline btn-mytheme btn-md pull-left"><i class="fa fa-plus"></i> <?=$this->lang->line('member_add_member')?></a> 
                    <a href="#" data-toggle="modal" data-target="#import" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-upload"></i> <?=$this->lang->line('member_import_member')?></a>
                    <div class="col-sm-3 pull-right">
                        <select name="roleID" id="filterRoleID" data-url="<?=base_url('member/index')?>" class="form-control pull-right">
                            <?php if(calculate($roles)) {
                                foreach ($roles as $roleID => $role) { ?>
                                    <option value="<?=$roleID?>" <?=($roleID==$setroleID) ? 'selected' : ''?>><?=$role ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?=$this->lang->line('member_slno')?></th>
                                <th><?=$this->lang->line('member_name')?></th>
                                <th><?=$this->lang->line('member_photo')?></th>
                                <th><?=$this->lang->line('member_email')?></th>
                                <th><?=$this->lang->line('member_classe')?></th>
                                <th><?=$this->lang->line('member_role')?></th>
                                <th><?=$this->lang->line('member_phone')?></th>
                                <?php if(permissionChecker('member_view') || permissionChecker('member_edit') || permissionChecker('member_delete')) { ?>
                                    <th><?=$this->lang->line('member_action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($members)) { $i=0; foreach($members as $member) { $i++; ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('member_slno')?>"><?=$i?></td>
                                    <td data-title="<?=$this->lang->line('member_name')?>"><?=$member->name?></td>
                                    <td data-title="<?=$this->lang->line('member_photo')?>"><img src="<?=profile_img($member->photo)?>" class="profile_img" alt=""></td>
                                    <td data-title="<?=$this->lang->line('member_email')?>"><?=$member->email?></td>
                                    <td data-title="<?=$this->lang->line('member_classe')?>"><?=isset($classes[$member->classeID]) ? $classes[$member->classeID] : ''?></td>
                                    <td data-title="<?=$this->lang->line('member_role')?>"><?=isset($roles[$member->roleID]) ? $roles[$member->roleID] : ''?></td>
                                    <td data-title="<?=$this->lang->line('member_phone')?>"><?=$member->phone?></td>
                                    <?php if(permissionChecker('member_view') || permissionChecker('member_edit') || permissionChecker('member_delete')) { ?>
                                        <td data-title="<?=$this->lang->line('member_action')?>">
                                            <?=btn_view('member/view/'.$member->memberID,$this->lang->line('member_view')); ?>
                                            <?=btn_edit('member/edit/'.$member->memberID,$this->lang->line('member_edit')); ?>
                                            <?=btn_delete('member/delete/'.$member->memberID,$this->lang->line('member_delete')); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?=$this->lang->line('member_slno')?></th>
                                <th><?=$this->lang->line('member_name')?></th>
                                <th><?=$this->lang->line('member_photo')?></th>
                                <th><?=$this->lang->line('member_email')?></th>
                                <th><?=$this->lang->line('member_classe')?></th>
                                <th><?=$this->lang->line('member_role')?></th>
                                <th><?=$this->lang->line('member_phone')?></th>
                                <?php if(permissionChecker('member_view') || permissionChecker('member_edit') || permissionChecker('member_delete')) { ?>
                                    <th><?=$this->lang->line('member_action')?></th>
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
                    <h4 class="modal-title"><?=$this->lang->line('member_import_member')?></h4>
                </div>
                <form action="<?=base_url('member/import')?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group <?=form_error('member_import') ? 'has-error' : ''?>">
                        <label for="member_import"> <?=$this->lang->line("member_import_file")?> <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="File types: xlxs, xlx, csv"></i></label>
                        <div class="input-group image-preview">
                            <input type="text" class="form-control fileuploadname" value="" disabled="disabled" />
                            <span class="input-group-btn">
                                <div class="btn btn-success image-preview-input">
                                    <span class="fa fa-repeat"></span>
                                    <span class="image-preview-input-title"><?=$this->lang->line('member_import_file')?></span>
                                    <input type="file" name="fileupload" accept=".xlsx, .xls, .csv" id="fileupload" required/>
                                </div>
                            </span>
                        </div>
                        <?=form_error('member_import');?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a target="_blank" href="<?=base_url('uploads/member/members.xlsx')?>" class="btn btn-inline btn-mytheme btn-md"><?=$this->lang->line('member_import_template')?></a>
                    <button type="submit" value="submit" name="submit" class="btn btn-inline btn-mytheme btn-md"><?=$this->lang->line('member_import')?></button>
                </div>
                </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
          <!-- Import -->
    </section>
</div>

<script>
    function import2(){
         alert("ok");
         return true;
    }
</script>