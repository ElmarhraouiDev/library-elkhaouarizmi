<div class="content-wrapper">
    <section class="content-header">
		<h1><?=$this->lang->line('booktype')?></h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
			<li class="active"><?=$this->lang->line('booktype')?></li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('booktype_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('booktype/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> <?=$this->lang->line('booktype_add_booktype')?></a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?=$this->lang->line('booktype_slno')?></th>
                                <th><?=$this->lang->line('booktype_name')?></th>
                                <th><?=$this->lang->line('booktype_description')?></th>
                                <?php if(permissionChecker('booktype_edit') || permissionChecker('booktype_delete')) { ?>
                                    <th><?=$this->lang->line('booktype_action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($booktypes)) { $i=0; foreach($booktypes as $booktype) { $i++; ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('booktype_slno')?>"><?=$i?></td>
                                    <td data-title="<?=$this->lang->line('booktype_name')?>"><?=$booktype->name?></td>
                                    <td data-title="<?=$this->lang->line('booktype_description')?>"><?=$booktype->description?></td>
                                    <?php if(permissionChecker('booktype_edit') || permissionChecker('booktype_delete')) { ?>
                                        <td data-title="<?=$this->lang->line('booktype_action')?>">
                                            <?=btn_edit('booktype/edit/'.$booktype->booktypeID,$this->lang->line('booktype_edit')); ?>
                                            <?=btn_delete('booktype/delete/'.$booktype->booktypeID,$this->lang->line('booktype_delete')); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?=$this->lang->line('booktype_slno')?></th>
                                <th><?=$this->lang->line('booktype_name')?></th>
                                <th><?=$this->lang->line('booktype_description')?></th>
                                <?php if(permissionChecker('booktype_edit') || permissionChecker('booktype_delete')) { ?>    
                                    <th><?=$this->lang->line('booktype_action')?></th>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
          </div>
    </section>
</div>