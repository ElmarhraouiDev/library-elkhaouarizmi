<style type="text/css">
	.mainidcard {
		margin: 0px auto;
		width: 710px;
		overflow: hidden;
		display: block;
	}

	.singleidcard {
		height: 340px;
		width: 320px;
		border: 1px solid #ddd;
		overflow: hidden;
		float: left;
		margin-bottom: 15px;
		margin-right: 15px;
		text-align: center;
		border-radius: 10px;
		position: relative;
	}

	.topbar {
		background: #2A54B4 !important;
		padding: 15px;
		margin-bottom: 4px;
		overflow: hidden;
		height: 40px;
	}

	.titlebar {
		padding-top: 5px;
		overflow: hidden;
		border-top: 2px solid #000;
		padding-bottom: 15px;
	}

	.titlebar span {
		font-size: 22px;
	    background: #2A54B4 !important;
	    font-weight: bold;
	    color: #fff !important;
	    padding: 0px 6px;
	    border-radius: 3px;
	}
	
	.infobar {
		padding: 0px 10px;		
	}

	.infobar img {
		width: 70px;
	    height: 75px;
	    border: 1px solid #ddd;
	    border-radius: 5px;
	}

	.infobar h3 {
		margin: 3px 0px;
		font-size: 22px;
	}

	.infobar p {
		margin-bottom: 0px;
	}

	.infobar span {
		font-weight: bold;
	}

	.backinfobar p {
		line-height: 22px;
	}

	.signaturebar {
		bottom: 50px;
		width: 100%;
		overflow: hidden;
		position: absolute;
		padding: 0px 10px;
	}

	.bar {
		width: 50%;
		float: left;
	}

	.bar img {
		width: 110px;
		height: 35px;
	}

	.signature {
		width: 50%;
		float: left;
		margin-top: 15px;
	}

	.signature span {
		font-weight: bold;
		text-decoration-line: overline;
	}
	

	.bottombar {
	    width: 100%;
	    color: #fff !important;
	    bottom: 0px;
	    position: absolute;
	}

	.bottombarborder {
		width: 100%;
		margin-bottom: 3px;
		border-bottom: 2px solid #000;
	}

	.bottombaraddress {
	    padding: 8px;
		font-weight: bold;
		background: #2A54B4 !important;	
	}

	.bottombaraddress span {
	    color: #fff !important;
	}

	@media print { body { -webkit-print-color-adjust: exact; } }	

	.reportheader {
		text-align: center;
		margin-bottom: 10px;
	}
	.reportheader p{
		margin-bottom: 0px;
	}
	.reporttable {
		overflow: hidden;
	}
	.reportnotfound {
		text-align: center;
		font-size: 20px;
		border: 1px solid #ddd;
		padding: 15px 10px;
	}

	.reportfooter {
		text-align: center;
	}

	.reportfooter h4 {
		margin-bottom: 2px;
	}

	.table-bordered {
		border: 1px solid #ddd;
	}

	@media print {
		body {
			-webkit-print-color-adjust: exact !important;
		}

		tr.info th {
			background: #d9edf7 !important;
		}
	}
</style>
<div class="reportheader">
	<h2><?=$generalsetting->sitename?></h2>
	<p><?=$generalsetting->phone?></p>
	<p><?=$generalsetting->email?></p>
	<p><?=$generalsetting->address?></p>
</div>
<?php if(calculate($members)) { ?>
	
<div class="mainidcard">
	<?php 
		$sitenames = str_split($generalsetting->sitename);
		foreach($members as $member) { ?>
			<?php $class = $this->classe_m->get_single_classe($member->classeID);?>
			<?php $role = $this->role_m->get_single_role($member->roleID);?>

			<?php if($mode==2) { ?>
			<div class="row">
				<div class="col-sm-4">
					<h3 class="text-left"><?=$member->name?></h3>
					<div>
						<img src="<?=base_url('uploads/idcard/'.$member->code.'.jpg')?>" alt="">
					</div>				
					<?php if (isset($options[0])) {?> <p><?=$this->lang->line('idcardreport_username')?>: <span><?=$member->username?></span></p> <?php } ?>
					<?php if (isset($options[1])) {?> <p><?=$this->lang->line('idcardreport_classeID')?>: <span><?=$class ? $class->classe : '' ?> <?= $options[7] ? $this->lang->line('idcardreport_group'). ' : '. $member->class_group : '' ?></span></p> <?php } ?>
					<?php if (isset($options[8])) {?> <p><?=$this->lang->line('idcardreport_birthday')?>: <span><?=app_date($member->dateofbirth)?>  <?= $options[7] ? ' '.$member->placeofbirth : '' ?> </span></p> <?php } ?>
					<?php if (isset($options[2])) {?> <p><?=$this->lang->line('idcardreport_role')?>: <span><?=$role ? $role->role : '' ?></span></p> <?php } ?>
					<?php if (isset($options[3])) {?> <p><?=$this->lang->line('idcardreport_phone_no')?>: <span><?=$member->phone?></span></p> <?php } ?>
					<?php if (isset($options[4])) {?> <p> <?=$this->lang->line('idcardreport_address')?>: <span><?=$member->address?></span></p> <?php } ?>
					<?php if (isset($options[5])) {?> <p><?=$this->lang->line('idcardreport_email_no')?>: <span><?=$member->email?></span></p> <?php } ?>
				</div>
			</div>

		<?php } elseif($type==1) { ?>
			<div class="singleidcard">
				<div class="topbar"></div>
				<div class="titlebar">
					<span><?php echo $generalsetting->sitename; ?></span>
				</div>
				<div class="infobar">
					<div class="row">
						<div class="col-sm-4">
							<img src="<?=profile_img($member->photo)?>" alt="">
						</div>
						<div class="col-sm-8 text-left">
						<h4 style="margin-bottom: 0;" class="text-center"><?=$member->name?></h4>
							<?php if (isset($options[0])) {?> <p><?=$this->lang->line('idcardreport_username')?>: <span><?=$member->username?></span></p> <?php } ?>
							<?php if (isset($options[2])) {?> <p><?=$this->lang->line('idcardreport_role')?>: <span><?=$role ? $role->role : '' ?></span></p> <?php } ?>
						</div>
					</div>
					<div class="row" style="margin-top: 5px;">
						<div class="col-sm-12 text-left">
							<?php if (isset($options[1])) {?> <p><?=$this->lang->line('idcardreport_classeID')?>: <span><?=$class ? $class->classe : '' ?> <?= $options[7] ? $this->lang->line('idcardreport_group'). ' : '. $member->class_group : '' ?></span></p> <?php } ?>
							<?php if (isset($options[8])) {?> <p><?=$this->lang->line('idcardreport_birthday')?>: <span><?=app_date($member->dateofbirth)?>  <?= $options[7] ? ' '.$member->placeofbirth : '' ?> </span></p> <?php } ?>
							<?php if (isset($options[3])) {?> <p><?=$this->lang->line('idcardreport_phone_no')?>: <span><?=$member->phone?></span></p> <?php } ?>
							<?php if (isset($options[4])) {?> <p> <?=$this->lang->line('idcardreport_address')?>: <span><?=$member->address?></span></p> <?php } ?>
							<?php if (isset($options[5])) {?> <p><?=$this->lang->line('idcardreport_email_no')?>: <span><?=$member->email?></span></p> <?php } ?>
						</div>
					</div>

					<?php if (isset($options[6])) {?>
						<div class="bar">
							<img src="<?=base_url('uploads/idcard/'.$member->code.'.jpg')?>" alt="">
						</div>
					<?php } ?>

				</div>
				<div class="bottombar">
					<div class="bottombarborder"></div>
					<div class="bottombaraddress">
						<span><?=$generalsetting->web_address?></span>
					</div>
				</div>
			</div>
		<?php } elseif($type==2) { ?>
			<div class="singleidcard">
				<div class="topbar"></div>
				<div class="titlebar" style="padding-bottom: 0px;"></div>
				<div class="infobar backinfobar">
					<p><?=$this->lang->line('idcardreport_card_property')?> <?=$generalsetting->sitename?></p>
					<p><u><?=$this->lang->line('idcardreport_found_please_return_to')?>:</u></p>
					<p><b><?=$generalsetting->sitename?></b></p>
					<p><i><?=$generalsetting->address?></i></p>
					<p><?=$this->lang->line('idcardreport_valid_till')?>: <span><?=date('d.m.Y', strtotime('Dec 31'))?></span></p>
				</div>
				<div class="signaturebar">
					<div class="bar">
						<img src="<?=base_url('uploads/idcard/'.$member->code.'.jpg')?>" alt="">
					</div>
					<div class="signature">
						<span><?=$this->lang->line('idcardreport_authorized')?></span>
					</div>
				</div>
				<div class="bottombar">
					<div class="bottombarborder"></div>
					<div class="bottombaraddress">
						<span><?=$generalsetting->web_address?></span>
					</div>
				</div>
			</div>
	<?php } } ?>
</div>
<?php } else { ?>
	<div class="reportnotfound">
		<?=$this->lang->line('idcardreport_data_not_available')?>
	</div>
<?php } ?>
<div class="reportfooter">
	<h4><?=$generalsetting->sitename?></h4>
	<p><?=$generalsetting->address?></p>
</div>