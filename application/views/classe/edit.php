<div class="content-wrapper">
    <section class="content-header">
        <h1><?=$this->lang->line('classe')?></h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
            <li><a href="<?=base_url('division/index')?>"><?=$this->lang->line('classe')?></a></li>
            <li class="active"><?=$this->lang->line('edit')?></li>
      </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="col-md-6">
                    <form classe="form" method="POST">
                        <div class="box-body">
                            <div class="form-group <?=form_error('classe') ? 'has-error' : ''?>">
                                <label for="classe"><?=$this->lang->line('classe_classe')?></label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('classe', $classe->classe)?>" id="classe" name="classe">
                                <?=form_error('classe')?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-mytheme"><?=$this->lang->line('classe_update_classe')?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>