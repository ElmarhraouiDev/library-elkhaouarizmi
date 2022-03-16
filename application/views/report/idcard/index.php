<?php header("Cache-Control: no cache");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1><?=$this->lang->line('idcardreport')?></h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('idcardreport')?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div class="row">
                    <form method="POST" action="<?=base_url('idcardreport/index')?>">
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('roleID') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('idcardreport_role')?></label>
                                <?php 
                                    $roleArray[0]   = $this->lang->line('idcardreport_please_select');
                                    if(calculate($roles)) {
                                        foreach($roles as $role) {
                                            $roleArray[$role->roleID] = $role->role;
                                        }
                                    }
                                    echo form_dropdown('roleID[]', $roleArray, set_value('roleID'),'id="roleID" class="form-control" multiple');
                                ?>
                                <?=form_error('roleID')?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('classeID') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('idcardreport_classeID')?></label>
                                <?php 
                                    $classesArray[0]   = $this->lang->line('idcardreport_please_select');
                                    if(calculate($classes)) {
                                        foreach($classes as $class) {
                                            $classesArray[$class->classeID] = $class->classe;
                                        }
                                    }
                                    echo form_dropdown('classeID[]', $classesArray, set_value('classeID'),'id="classeID" class="form-control" multiple');
                                ?>
                                <?=form_error('classeID')?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('memberID') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('idcardreport_member')?></label>
                                <?php 
                                    $memberArray[0]   = $this->lang->line('idcardreport_please_select');
                                    if(calculate($members)) {
                                        foreach($members as $member) {
                                            $memberArray[$member->memberID] = $member->name;
                                        }
                                    }
                                    echo form_dropdown('memberID[]', $memberArray, set_value('memberID'),'id="memberID" class="form-control" multiple');
                                ?>
                                <?=form_error('memberID')?>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group <?=form_error('type') ? 'has-error' : ''?>">
                                        <label><?=$this->lang->line('idcardreport_type')?></label> <span class="text-red">*</span>
                                        <?php 
                                            $typeArray[0]   = $this->lang->line('idcardreport_please_select');
                                            $typeArray[1]   = $this->lang->line('idcardreport_front_part');
                                            $typeArray[2]   = $this->lang->line('idcardreport_back_part');
                                            echo form_dropdown('type', $typeArray, set_value('type'),'id="type" class="form-control"');
                                        ?>
                                        <?=form_error('type')?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">

                            <div class="row">
                                <div class="col-sm-4">
                                    <span class="input-group-addon ck_input">
                                        <input id="rd_mode_advenced" name="rd_mode" type="radio" value="1" checked>
                                        <label for="rd_mode_advenced">Advenced Mode</label>
                                    </span>
                                    <span class="input-group-addon ck_input">
                                        <input id="rd_mode_simple" name="rd_mode" type="radio" value="2">
                                        <label for="rd_mode_simple">Simple Mode</label>
                                    </span>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_username" name="ck_username" type="checkbox">
                                            <label for="ck_username">Username</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_class" name="ck_class" type="checkbox">
                                            <label for="ck_class">Class</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_class_group" name="ck_class_group" type="checkbox">
                                            <label for="ck_class_group">Class group</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_birthday" name="ck_birthday" type="checkbox">
                                            <label for="ck_birthday">Birthday</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_birthplace" name="ck_birthplace" type="checkbox">
                                            <label for="ck_birthplace">Birthplace</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_role" name="ck_role" type="checkbox">
                                            <label for="ck_role">Role</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_phone" name="ck_phone" type="checkbox">
                                            <label for="ck_phone">Phone</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_address" name="ck_address" type="checkbox">
                                            <label for="ck_address">Address</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_email" name="ck_email" type="checkbox">
                                            <label for="ck_email">Email</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_fbarcode" name="ck_fbarcode" type="checkbox">
                                            <label for="ck_fbarcode">barcode in front</label>
                                        </span>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->

                            <div class="form-group">
                                <button class="btn btn-mytheme" style="margin-top: 5px"><?=$this->lang->line('idcardreport_get_card')?></button>
                                <?php if($flag) { ?>
                                    <button onclick="printDiv()" class="btn btn-mytheme divhide" style="margin-top: 5px"><?=$this->lang->line('idcardreport_print_card')?></button>
                                    <button name="print_pdf" class="btn btn-mytheme divhide" style="margin-top: 5px"><?=$this->lang->line('idcardreport_pdf_card')?></button>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if($flag) { ?>
            <div class="box box-mytheme divhide">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12" id="printDiv">
                            <?php $this->load->view('report/idcard/view')?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
</div>

<script type="text/javascript">

    function printDiv() {
        var oldPage  = document.body.innerHTML;
        var printDiv = document.getElementById('printDiv').innerHTML;
        document.body.innerHTML = "<html><head><title>"+document.title+"</title></head><body>"+printDiv+"</body></html>";
        window.print();
        document.body.innerHTML = oldPage;
        window.location.reload();
    }

    $('#roleID').fastselect();
	$('#memberID').fastselect();
	$('#classeID').fastselect();
   
</script>