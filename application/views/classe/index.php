<div class="content-wrapper">
    <section class="content-header">
		<h1><?=$this->lang->line('classe')?></h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('classe')?></li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('division_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('division/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> <?=$this->lang->line('classe_add_classe')?></a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?=$this->lang->line('classe_slno')?></th>
                                <th><?=$this->lang->line('classe_classe')?></th>
                                <th><?=$this->lang->line('classe_create_date')?></th>
                                <?php if(permissionChecker('division_edit') || permissionChecker('division_delete')) { ?>
                                    <th><?=$this->lang->line('classe_action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(calculate($classes)) { $i=0; foreach($classes as $classe) { $i++; ?>
                            <tr>
                                <td data-title="<?=$this->lang->line('classe_slno')?>"><?=$i?></td>
                                <td data-title="<?=$this->lang->line('classe_classe')?>"><?=$classe->classe?></td>
                                <td data-title="<?=$this->lang->line('classe_create_date')?>"><?=app_date($classe->create_date)?></td>
                                <?php if(permissionChecker('division_edit') || permissionChecker('division_delete')) { ?>
                                    <td data-title="<?=$this->lang->line('classe_action')?>">
                                        <?=btn_edit('division/edit/'.$classe->classeID, $this->lang->line('classe_edit'))?>
                                        <?=btn_delete('division/delete/'.$classe->classeID, $this->lang->line('classe_delete'))?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?=$this->lang->line('classe_slno')?></th>
                                <th><?=$this->lang->line('classe_classe')?></th>
                                <th><?=$this->lang->line('classe_create_date')?></th>
                                <?php if(permissionChecker('division_edit') || permissionChecker('division_delete')) { ?>
                                    <th><?=$this->lang->line('classe_action')?></th>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>