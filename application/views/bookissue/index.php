<div class="content-wrapper">
    <section class="content-header">
        <h1><?=$this->lang->line('bookissue')?></h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i><?=$this->lang->line('dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('bookissue')?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="bookissuesearchbox">

                    <?php if(permissionChecker('bookissue_add')) { ?>
                        <div class="col-sm-2 col-sm-offset-1">
                            <input type="password" class="form-control" id="issue_memberID" name="issue_memberID" placeholder="Member ID">
                        </div>

                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="issue_booksID" name="issue_booksID" placeholder="Books ID" style="display: none;">
                        </div>
                        
                        <div class="col-sm-3">
                            <button id="btn_cancel" class="btn btn-inline btn-mytheme btn-md" style="background-color: #bc3c3c;border-color: #bc3c3c; display: none;" data-toggle="tooltip" data-original-title="Cancel Issue"><i class="fa fa-times"></i></button>
                            <button id="btn_profile" class="btn btn-inline btn-mytheme btn-md" style="background-color: #3c8dbc;border-color: #3c8dbc; display: none;" data-toggle="tooltip" data-original-title="Member Profile"><i class="fa fa-user"></i></button>
                            <button id="btn_addnote" class="btn btn-inline btn-mytheme btn-md" style="display: none;" data-toggle="tooltip" data-original-title="Add Note Issue" ><i class="fa fa-sticky-note"></i></button>
                            <button id="btn_addissue" class="btn btn-inline btn-mytheme btn-md" style="display: none;" data-toggle="tooltip" data-original-title="<?=$this->lang->line('bookissue_add_book_issue')?>"><i class="fa fa-plus"></i>  <?=$this->lang->line('bookissue_add_book_issue')?></button>
                        </div>

                        <div id="container_ids" class="col-sm-5 col-sm-offset-3">
                            
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>
        <div class="box box-mytheme">
            <div class="box-body">
            <div class="row">
                    <div class="col-sm-4 col-sm-offset-3">
                        <div class="box-body">
                            <div class="input-group ck_input_bookissue">
                                
                                <input id="issue_booksID_filter" type="text" class="form-control" value="<?=set_value('bookID', $memberID)?>" name="bookID" placeholder="Filter By Book ID">
                                <div class="input-group-btn">
                                    <button type="submit" id="btn_booksID_filter" class="btn btn-default"><i class="fa fa-search-plus" aria-hidden="true"></i> <?=$this->lang->line('bookissue_search')?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="container_ids_books" class="col-sm-5 col-sm-offset-3"></div>
            </div>
            
            <div class="row">
                <div class="col-sm-12" id="btns_actions">
                    <button id="return_all" class="btn btn-info btn-xs mrg btnactions" style="background-color: #8900cf;border-color: #9227c9;float: right; margin-right: 5px;margin-bottom: 5px;" data-placement="auto" data-toggle="tooltip" data-original-title="<?=$this->lang->line('bookissue_return')?>"><i class="fa fa-undo"></i></button>
                    <button id="delete_all" class="btn btn-danger btn-xs mrg btnactions" data-placement="auto" style="float: right;margin-right: 5px;margin-bottom: 5px;" data-toggle="tooltip" data-original-title="<?=$this->lang->line('bookissue_delete')?>"><i class="fa fa-trash-o"></i></button>
                    <button id="select_all" data-checked="false" class="btn btn-primary btn-xs mrg btnactions" data-placement="auto" style="float: right;margin-right: 5px;margin-bottom: 5px;" data-toggle="tooltip" data-original-title="<?=$this->lang->line('bookissue_selectall')?>"><i class="fa fa-check-square"></i></button>
                </div>
            </div>

                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input class="allChecked" type="checkbox"/></th>
                                <th><?=$this->lang->line('bookissue_slno')?></th>
                                <th><?=$this->lang->line('bookissue_member')?></th>
                                <th><?=$this->lang->line('bookissue_category')?></th>
                                <th><?=$this->lang->line('bookissue_book')?></th>
                                <th><?=$this->lang->line('bookissue_book_code_no')?></th>
                                <th><?=$this->lang->line('bookissue_book_no')?></th>
                                <th><?=$this->lang->line('bookissue_book_novol')?></th>
                                <th><?=$this->lang->line('bookissue_status')?></th>
                                <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                    <th><?=$this->lang->line('bookissue_action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($bookissues)) { $i=0; foreach($bookissues as $bookissue) { $i++; ?>
                            <tr class="clickable-row" id="<?=$bookissue->bookissueID ?>">
                                <td><input type="checkbox"/></td>
                                <td data-title="<?=$this->lang->line('bookissue_slno')?>"><?=$i?></td>
                                <td data-title="<?=$this->lang->line('bookissue_member')?>"><?=isset($members[$bookissue->memberID]) ? $members[$bookissue->memberID] : ''?></td>
                                <td data-title="<?=$this->lang->line('bookissue_category')?>"><?=isset($bookcategory[$bookissue->bookcategoryID]) ? $bookcategory[$bookissue->bookcategoryID] : 'Uncategorized'?></td>
                                <td data-title="<?=$this->lang->line('bookissue_book')?>"><?=isset($book[$bookissue->bookID]) ? $book[$bookissue->bookID] : ''?></td>
                                <td data-title="<?=$this->lang->line('bookissue_book_code_no')?>"><?=isset($bookcodeno[$bookissue->bookID]) ? $bookcodeno[$bookissue->bookID] : ''?></td>
                                <td data-title="<?=$this->lang->line('bookissue_book_no')?>"><?=$bookissue->bookno?></td>
                                <td data-title="<?=$this->lang->line('bookissue_book_novol')?>"><?=$bookissue->booknovol?></td>
                                <td data-title="<?=$this->lang->line('bookissue_status')?>">
                                <?php 
                                            $date_current = date('Y-m-d H:i:s');
                                            $date_bookissue_exp = $bookissue->expire_date;
                                            $status_color = "green";
                                            if($bookissue->status == 0 && $date_current > $date_bookissue_exp) {
                                                $status = $this->lang->line('bookissue_issued_delayed');              
                                                $status_color = "red";              
                                            } elseif($bookissue->status == 0) {
                                                $status = $this->lang->line('bookissue_issued');              
                                            } elseif ($bookissue->status == 1 && ($bookissue->paidstatus != 2) && ($bookissue->fineamount > 0)) {
                                                $status = $this->lang->line('bookissue_return'); 
                                                $status_color = "red";             
                                            } elseif ($bookissue->status == 1) {
                                                $status = $this->lang->line('bookissue_return');              
                                            } elseif ($bookissue->status == 2) {
                                                $status = $this->lang->line('bookissue_lost');
                                            }
                                        ?>    
                                    <span class="text-bold text-success" style="color: <?= $status_color ?>"> <?= $status ?> </span>
                                </td>
                                
                                <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                <td data-title="<?=$this->lang->line('bookissue_action')?>">
                                    <?=btn_view('bookissue/view/'.$bookissue->bookissueID,$this->lang->line('bookissue_view')); ?>
                                    <?php if(($bookissue->status == 0) && ($bookissue->deleted_at == 0) && ($bookissue->renewed == 1)) { 
                                        echo btn_edit('bookissue/edit/'.$bookissue->bookissueID, $this->lang->line('bookissue_edit')). " ";
                                        echo btn_delete('bookissue/delete/'.$bookissue->bookissueID, $this->lang->line('bookissue_delete'));
                                    } ?>
                            
                                    <?php if($bookissue->status == 0) { ?>
                                        <a href="<?=base_url('bookissue/renewandreturn/'.$bookissue->bookissueID)?>" class="btn btn-info btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="<?=$this->lang->line('bookissue_renew_or_return')?>"><i class="fa fa-retweet"></i></a>
                                        <a href="<?=base_url('bookissue/returnbook/'.$bookissue->bookissueID)?>" class="btn btn-info btn-xs mrg" style="background-color: #8900cf;border-color: #9227c9;" onclick="return confirm('Do you really want to return the book. This cannot be undone. are you sure?')" data-placement="auto" data-toggle="tooltip" data-original-title="<?=$this->lang->line('bookissue_return')?>"><i class="fa fa-undo"></i></a>
                                    <?php } ?>
    
                                    <?php if(permissionChecker('bookissue_add') && ($bookissue->paidstatus != 2) && ($bookissue->fineamount > 0)) { ?>
                                        <span data-toggle="tooltip" data-original-title="<?=$this->lang->line('bookissue_payment')?>"><button class="btn btn-mytheme btn-xs mrg paymentamount" data-bookissueid="<?=$bookissue->bookissueID?>" data-placement="auto" data-toggle="modal" data-target="#paymentmodal"><i class="fa fa-money"></i></button></span>
                                    <?php } ?>
                                    
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th><input class="allChecked" type="checkbox"/></th>
                            <th><?=$this->lang->line('bookissue_slno')?></th>
                            <th><?=$this->lang->line('bookissue_member')?></th>
                            <th><?=$this->lang->line('bookissue_category')?></th>
                            <th><?=$this->lang->line('bookissue_book')?></th>
                            <th><?=$this->lang->line('bookissue_book_code_no')?></th>
                            <th><?=$this->lang->line('bookissue_book_no')?></th>
                            <th><?=$this->lang->line('bookissue_book_novol')?></th>
                            <th><?=$this->lang->line('bookissue_status')?></th>
                            <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                <th><?=$this->lang->line('bookissue_action')?></th>
                            <?php } ?>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php if(permissionChecker('bookissue_add')) { ?>
    <div class="modal fade" id="paymentmodal" tabindex="-1" role="dialog" aria-labelledby="paymentmodaltitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="paymentform">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="paymentmodaltitle"><?=$this->lang->line('bookissue_add_payment')?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" id="paymentamounterrorDiv">
                                    <label for="paymentamount"><?=$this->lang->line('bookissue_payment_amount')?></label> <span class="text-red">*</span>
                                    <input type="text" class="form-control" data-paymentamount="0" id="paymentamount" name="paymentamount">
                                    <span class="help-block totalfineamount" style="color: #a94442"></span>
                                    <span id="paymentamounterror"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" id="discountamounterrorDiv">
                                    <label for="discountamount"><?=$this->lang->line('bookissue_discount_amount')?></label> <span class="text-red">*</span>
                                    <input type="text" class="form-control" id="discountamount" name="discountamount">
                                    <span id="discountamounterror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" id="noteserrorDiv">
                                    <label for="notes"><?=$this->lang->line('bookissue_notes')?></label>
                                    <textarea class="form-control" name="notes" id="notes" cols="30" rows="3"></textarea>
                                    <span id="noteserror"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('bookissue_close')?></button>
                        <button type="submite" class="btn btn-mytheme submitpaymentamount"><?=$this->lang->line('bookissue_submit')?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

 <!-- profile modal -->
<div id="profile" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="padding: 5px 15px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div id="modalprofile" class="modal-body" style="background-color: #ecf0f5;">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">More</button>
        <button type="button" class="btn btn-primary">Finish</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- add note modal -->
<div id="addnote" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="padding: 5px 15px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Note</h4>
      </div>
      <div class="modal-body" style="background-color: #ecf0f5;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-body">
                        <input type="text" id="issue_note" class="form-control" value="" placeholder="Add Note">
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_addissuenote" class="btn btn-primary" data-dismiss="modal">Add</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var books_ids = [];
    var books_ids_seletions = [];
    var issue_note = '';

    var books_ids_filter = [];
    var books_ids_seletions_filter = [];

    $("#issue_memberID").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            var value = $(this).val();
            $.ajax({
                url: "<?=base_url('bookissue/getmember')?>/" + value,
                dataType: "JSON",
                type: "get",
                success: function (response) {
                    if (response['success'] == 0) {
                        $("#issue_memberID").prop('disabled', true);
                        $("#issue_booksID").show();
                        $("#btn_cancel").show();
                        $("#btn_profile").show();
                        $("#btn_addnote").show();
                        $("#btn_addissue").show();
                        $("#issue_booksID").focus();
                        books_ids = response['books'];
                        console.log(books_ids)
                    } else {
                        $("#issue_memberID").prop('disabled', false);
                        $("#issue_memberID").focus();
                        $("#issue_booksID").hide();
                        $("#btn_cancel").hide();
                        $("#btn_profile").hide();
                        $("#btn_addnote").hide();
                        $("#btn_addissue").hide();
                        $("#issue_memberID").val('');
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#issue_memberID").prop('disabled', false);
                    $("#issue_memberID").focus();
                    $("#issue_booksID").hide();
                    $("#btn_cancel").hide();
                    $("#btn_profile").hide();
                    $("#btn_addnote").hide();
                    $("#btn_addissue").hide();
                    $("#issue_memberID").val('');
                }
            });
        }
    });

    $("#issue_booksID").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            var value = $(this).val();
            //  && !books_ids_seletions.includes(value)
            if (books_ids.includes(value)) {
                books_ids_seletions.push(value);
                valuechanged = value.replace("/", "_");
                $("#container_ids").append("<span onclick=remove_id('"+value+"') class='label label-primary btncode "+valuechanged+"' style='margin-right: 5px;'>"+value+"</span>");
            } else {
                console.log('error00')
            }
            
            $("#issue_booksID").val('');
        }
    });

    $("#btn_cancel").on('click', function (e) {
        $("#issue_memberID").prop('disabled', false);
        $("#issue_memberID").focus();
        $("#issue_booksID").hide();
        $("#btn_cancel").hide();
        $("#btn_profile").hide();
        $("#btn_addnote").hide();
        $("#btn_addissue").hide();
        $("#issue_memberID").val('');
        $("#container_ids").empty();
        books_ids = [];
        books_ids_seletions = [];
    });

    function remove_id(id) {
        books_ids_seletions.splice(books_ids_seletions.indexOf(id),1);
        idchanged = id.replace("/", "_");
        $( "."+idchanged ).remove();
    }

    function remove_id_filter(id) {
        books_ids_seletions_filter.splice(books_ids_seletions_filter.indexOf(id),1);
        idchanged = id.replace("/", "_");
        $( "._"+idchanged ).remove();
    }

    $("#btn_profile").on('click', function (e) {
        var value = $('#issue_memberID').val();
        $.ajax({
                url: "<?=base_url('bookissue/viewprofile')?>/" + value,
                type: "get",
                success: function (response) {
                    $('#modalprofile').html(response);
                    $('#profile').modal('show');
                    console.log('11111111')
                }
            });
    });

    $("#btn_addissue").on('click', function (e) {
        if (books_ids_seletions.length > 0 && $("#issue_memberID").val() != '') {
            var values = {"memberID": $("#issue_memberID").val(), "bookCodes": books_ids_seletions, "notes": issue_note};
            $.ajax({
                url: "<?=base_url('bookissue/addfast')?>",
                dataType: "JSON",
                data : values,
                type: "post",
                success: function (response) {
                    window.location.href = '<?=base_url('bookissue')?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   
                }
            });

            $("#btn_addissue").prop('disabled', true);

        }
    });

    $("#btn_addnote").on('click', function (e) {
        $('#issue_note').val(issue_note);
        $('#addnote').modal('show');
    });

    $("#btn_addissuenote").on('click', function (e) {
        issue_note = $('#issue_note').val();
    });

    // $('#example1').on('click', '.clickable-row', function(event) {
    //     $(this).toggleClass('activerow');
    // });

    $('.allChecked').on('click', function(event) {
        if ($(this).prop('checked')) {
            $('input[type="checkbox"]').prop('checked', 'checked')
        } else {
            $('input[type="checkbox"]').prop('checked', '')
        }
    });

    $('#return_all').on('click', function(event) {

            var ids = '';
            $(':checkbox:checked').each(function( index ) {
                var id = $(this).closest('tr').attr('id');
                if (id !== undefined) {
                    ids += id + '.';
                }
            });

            if (ids != '') {
                if (confirm('Do you really want to return the books. This cannot be undone. are you sure?')) {
                    window.location.href = '<?=base_url('bookissue/returnallbook/')?>' + ids;
                }
            }

    });

    $('#delete_all').on('click', function(event) {

            var ids = '';
            $(':checkbox:checked').each(function( index ) {
                var id = $(this).closest('tr').attr('id');
                if (id !== undefined) {
                    ids += id + '.';
                }
            });

            if (ids != '') {
                if (confirm('Do you really want to delete the books. This cannot be undone. are you sure?')) {
                    window.location.href = '<?=base_url('bookissue/deleteallbook/')?>' + ids;
                }
            }

    });

    $('#select_all').on('click', function(event) {
        if ($(this).data('checked') == false) {
            $('input[type="checkbox"]').prop('checked', 'checked')
            $(this).data('checked', true);
        } else {
            $('input[type="checkbox"]').prop('checked', '')
            $(this).data('checked', false);
        }
    });


    $("#issue_booksID_filter").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            var value = $(this).val();

            if (!books_ids_seletions_filter.includes(value)) {
                books_ids_seletions_filter.push(value);
                valuechanged = value.replace("/", "_");
                $("#container_ids_books").append("<span onclick=remove_id_filter('"+value+"') class='label label-primary btncode _"+valuechanged+"' style='margin-right: 5px;'>"+value+"</span>");
            } else {
                console.log('error')
            }
            
            $("#issue_booksID_filter").val('');
        }
    });

    $("#btn_booksID_filter").on('click', function (e) {
        if (books_ids_seletions_filter.length > 0) {
            var values = {"books_ids_filter": books_ids_seletions_filter, "action": "filter"};
            $.ajax({
                url: "<?=base_url('bookissue/index')?>",
                data : values,
                type: "post",
                success: function (response) {
                    $("#example1").html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   
                }
            });
        }
    });

</script>