<div class="content-wrapper">
    <section class="content-header">
        <h1><?=$this->lang->line('bookreport')?></h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('bookreport')?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <form method="POST" action="<?=base_url('bookreport/index')?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookcategoryID') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('bookreport_book_category')?></label>

                                <?php 

									$parent_catagory = array();
									$parent_catagory_order = array();
									$parent_catagory_ids = array();

								  	foreach($bookcategorys as $catagory) {
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
									$parent_catagory_order['-1'] = $this->lang->line('bookreport_please_select');
									$parent_catagory_order = array_reverse($parent_catagory_order, true);
									echo form_dropdown('bookcategoryID', $parent_catagory_order, set_value('bookcategoryID'),'id="bookcategoryID" class="form-control" ');
								?>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookID') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('bookreport_book')?></label>
                                <?php 
                                    $bookArray[0]   = $this->lang->line('bookreport_please_select');
                                    echo form_dropdown('bookID', $bookArray, set_value('bookID'),'id="bookID" class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
                                <label><?=$this->lang->line('bookreport_status')?></label>
                                <?php 
                                    $statusArray[0]   = $this->lang->line('bookreport_please_select');
                                    $statusArray[1]   = $this->lang->line('bookreport_available');
                                    $statusArray[2]   = $this->lang->line('bookreport_not_available');
                                    echo form_dropdown('status', $statusArray, set_value('status'),'id="status" class="form-control"');
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <button class="btn btn-mytheme" style="margin-top: 15px"><?=$this->lang->line('bookreport_get_book')?></button>
                                <?php if($flag) { ?>
                                    <button class="btn btn-mytheme divhide" onclick="printDiv()" style="margin-top: 15px"><?=$this->lang->line('bookreport_print_book')?></button>
                                    <a href="<?=base_url('bookreport/pdf/'.$bookcategoryID.'/'.$bookID.'/'.$status)?>" class="btn btn-mytheme divhide" style="margin-top: 15px" target="_blank"><?=$this->lang->line('bookreport_pdf_book')?></a>
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
                            <?php $this->load->view('report/book/view')?>
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

    $('#bookID').fastselect();
    $('#status').fastselect();

    $('#bookcategoryID').fastselect({
				'onItemCreate': function($item, model, fastsearchApi){
					console.log($item.html());
					if (!$item.html().includes('&nbsp;')) {
						// $item.text($item.text().replace("{bold}", ""));
						$item.attr('style', 'font-weight: 800;')
					}
				}
			});
</script>