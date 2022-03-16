<style type="text/css">
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
	}

	.booklist {
		overflow: hidden;
	}

	.bookitem {
		width: 150px;
		margin:0px 15px 25px 0px;
		float: left;
	}

	.bookitem p {
		text-align: center;
		margin-bottom: 2px;	
	}

	.bookitem img {
		width: 150px;
		height: 40px;
	}

</style>
<div class="reportheader">
	<h2><?=$generalsetting->sitename?></h2> 
	<p><?=$generalsetting->phone?></p>
	<p><?=$generalsetting->email?></p>
	<p><?=$generalsetting->address?></p>
</div>
<?php if(calculate($bookitems)) { ?>
	<div class="booklist">
		<?php foreach ($bookitems as $bookitem) { ?>
			<?php $book = $this->book_m->get_single_book(['bookID' => $bookitem->bookID]);?>
			<?php $type = isset($options[1]) ? $this->booktype_m->get_single_booktype(array('booktypeID' => $book->booktypeID)) : null ?>
			<?php $catagory = isset($options[3]) ? $this->bookcategory_m->get_single_bookcategory(array('bookcategoryID' => trim($book->bookcategoryID))) : null ?>
			<?php $rack = isset($options[4]) ? $this->rack_m->get_single_rack(array('rackID' => $book->rackID)) : null ?>

			<?php if(!calculate($book)) {
                    continue;
                }?>
			<div class="bookitem">
				<p><?=$book->codeno.'-'.$bookitem->bookno.'-'.$bookitem->booknovol.'/'.$book->volume?></p>
				<img src="<?=base_url('uploads/bookbarcode/'.$book->codeno.'-'.$bookitem->bookno.'-'.$bookitem->booknovol.'.jpg')?>" alt="">
				<?=isset($options[0]) ? '<span> Name: '.$book->name.'</span><br>' : '' ?>
				<?=isset($type) ? ' <span> Type: '.$type->name.'</span><br>' : '' ?>
				<?=isset($options[2]) ? '<span> Author: '.$book->author.'</span><br>' : '' ?>
				<?=isset($catagory) ? '<span> Catagory: '.$catagory->name.'</span><br>' : '' ?>
				<?=isset($rack) ? '<span> Rack: '.$rack->name.'</span><br>' : '' ?>
				<?=isset($options[5]) ? '<span> ISBN: '.$book->isbnno.'</span><br>' : '' ?>

			</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<div class="reportnotfound">
		<?=$this->lang->line('bookbarcode_book_not_available')?>
	</div>
<?php } ?>
<div class="reportfooter">
	<h4><?=$generalsetting->sitename?></h4>
	<p><?=$generalsetting->address?></p>
</div>