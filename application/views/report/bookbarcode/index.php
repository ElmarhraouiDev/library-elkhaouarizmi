<div class="content-wrapper">
    <section class="content-header">
        <h1><?=$this->lang->line('bookbarcodereport')?></h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('bookbarcodereport')?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <form method="POST" action="<?=base_url('bookbarcodereport/index')?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookcategoryID') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('bookbarcodereport_book_category')?></label>

                                <?php 

									$parent_catagory = array();
									$parent_catagory_order = array();
									$parent_catagory_ids = array();

								  	foreach($bookcategory_all as $catagory) {
										$index = array_search($catagory->parent_catagory, $parent_catagory_ids) ? array_search($catagory->parent_catagory, $parent_catagory_ids) : 0; 
										$inserted = $catagory->bookcategoryID; 
										array_splice($parent_catagory_ids, $index, 0, $inserted);
										$str = generateString('&nbsp&nbsp&nbsp', $catagory->level_in_catagory) . $catagory->name;
										if ($catagory->level_in_catagory == '0') {
												$str .= '{bold}';
										}
										$parent_catagory[$catagory->bookcategoryID] = $str;
									}
									
								  	foreach($parent_catagory_ids as $catagory_id) {
										$parent_catagory_order[$catagory_id] = $parent_catagory[$catagory_id] ;
									}
									$parent_catagory_order['-1'] = $this->lang->line('bookbarcodereport_please_select');
									$parent_catagory_order = array_reverse($parent_catagory_order, true);
									echo form_dropdown('bookcategoryID[]', $parent_catagory_order, set_value('bookcategoryID'),'id="bookcategoryID" class="form-control" multiple');
								?>
                                
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('booktypeID') ? 'has-error' : ''?>">
							  	<label for="booktypeID"><?=$this->lang->line('bookbarcodereport_booktype')?></label>
								<?php 
									$booktypeArray 		= [];
									$booktypeArray[0]	= $this->lang->line('bookbarcodereport_please_select');
									if(calculate($booktypes)) {
										foreach($booktypes as $booktype) {
											$booktypeArray[$booktype->booktypeID] = $booktype->name;
										}
									}

									echo form_dropdown('booktypeID[]', $booktypeArray, set_value('booktypeID'), 'id="booktypeID" class="form-control" multiple');
								?>
							  	<?=form_error('booktypeID')?>
							</div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookID') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('bookbarcodereport_book')?></label>
                                <?php
                                    $bookArray[0]   = $this->lang->line('bookbarcodereport_please_select');
                                    if(calculate($books)) {
                                        foreach($books as $book) {
                                            $bookArray[$book->bookID] = $book->name . ' - ' . $book->codeno;
                                        }
                                    } 
                                    echo form_dropdown('bookID[]', $bookArray, set_value('bookID'),'id="bookID" class="form-control" multiple');
                                ?>
                            </div>
                        </div>
                        
                    
                        <div class="col-sm-12">
                        <span><strong>Custom Label: (Check Boxes: check information to generate)</strong></span>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_name" name="ck_name" type="checkbox">
                                            <label for="ck_name">Name</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_type" name="ck_type" type="checkbox">
                                            <label for="ck_type">Type</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_author" name="ck_author" type="checkbox">
                                            <label for="ck_author">Author</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_catagory" name="ck_catagory" type="checkbox">
                                            <label for="ck_catagory">Catagory</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_rack" name="ck_rack" type="checkbox">
                                            <label for="ck_rack">Rack</label>
                                        </span>
                                        <span class="input-group-addon ck_input">
                                            <input id="ck_isbn" name="ck_isbn" type="checkbox">
                                            <label for="ck_isbn">ISBN</label>
                                        </span>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->

                            <div class="form-group">
                                <button name="get_books" class="btn btn-mytheme" style="margin-top: 23px"><?=$this->lang->line('bookbarcodereport_get_barcode')?></button>
                                <?php if($flag) { ?>
                                    <button class="btn btn-mytheme divhide" onclick="printDiv()" style="margin-top: 23px"><?=$this->lang->line('bookbarcodereport_print_barcode')?></button>
                                    <button type="submit" name="print_pdf" class="btn btn-mytheme divhide" style="margin-top: 23px"><?=$this->lang->line('bookbarcodereport_pdf_barcode')?></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if($flag) { ?>
            <div class="box box-mytheme divhide">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12" id="printDiv">
                            <?php $this->load->view('report/bookbarcode/view')?>
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
        document.body.innerHTML = '<html><head><title>'+document.title+'</title></head><body>'+printDiv+'</body></html>';
        window.print();
        document.body.innerHTML = oldPage;
        window.location.reload();
    }
	$('#bookcategoryID').fastselect({
				'onItemCreate': function($item, model, fastsearchApi){
					console.log($item.html());
					if (!$item.html().includes('&nbsp;')) {
						// $item.text($item.text().replace("{bold}", ""));
						$item.attr('style', 'font-weight: 800;')
					}
				}
			});
            
	$('#booktypeID').fastselect();
	$('#bookID').fastselect();
</script>