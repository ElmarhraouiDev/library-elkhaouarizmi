<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ID Card Report</title>
</head>
<body>
	<div class="reportheader">
		
	</div>
	<div>
	<?php if(calculate($members)) { 
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
					<div class="titlebarcenter" style="margin-left: 0px">
						<?php 
							echo "<div class='titlebarletterwidth'>".$generalsetting->sitename."</div> ";
						?>	
					</div>
				</div>
				<div class="infobar">
					<div class="row">
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<img src="<?=profile_img($member->photo)?>" alt="">
						</div>
						<div class="col-sm-9 text-left">
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
					<p> <span><?=date('d.m.Y', strtotime('Dec 31'))?></span></p>
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
	<?php } } } else { ?>
		<div class="reportnotfound">
			<?=$this->lang->line('idcardreport_data_not_available')?>
		</div>
	<?php } ?>
	</div>
	<div class="reportfooter">

	</div>
</body>
</html>