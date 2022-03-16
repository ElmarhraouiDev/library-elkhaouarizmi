    <section class="content" style="background-color: #ecf0f5;">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-mytheme">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?=profile_img($member->photo)?>" alt="<?=$member->name?> profile picture">
                        <h3 class="profile-username text-center"><?=$member->name?></h3>
                        <p class="text-muted text-center"><?=calculate($role) ? $role->role : ''?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b><?=$this->lang->line('member_gender')?></b> <span class="pull-right"><?=$member->gender?></span>
                            </li>
                            <li class="list-group-item">
                                <b><?=$this->lang->line('member_phone')?></b> <span class="pull-right"><?=$member->phone?></span>
                            </li>
                            <li class="list-group-item">
                                <b><?=$this->lang->line('member_email')?></b> <span class="pull-right"><?=$member->email?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#bookissue" data-toggle="tab"><?=$this->lang->line('member_book_issue')?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="bookissue">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="hide-table">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?=$this->lang->line('member_category')?></th>
                                                    <th><?=$this->lang->line('member_book')?></th>
                                                    <th><?=$this->lang->line('bookissue_book_code_no')?></th>
                                                    <th><?=$this->lang->line('member_status')?></th>
                                                    <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                                        <th><?=$this->lang->line('bookissue_action')?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(calculate($bookissues)) { $i=0; foreach($bookissues as $bookissue) { $i++; ?>
                                                <tr>
                                                    <td data-title="#"><?=$i?></td>
                                                    <td data-title="<?=$this->lang->line('member_category')?>"><?=isset($bookcategory[$bookissue->bookcategoryID]) ? $bookcategory[$bookissue->bookcategoryID] : 'Uncategorized'?></td>
                                                    <td data-title="<?=$this->lang->line('member_book')?>"><?=isset($book[$bookissue->bookID]) ? $book[$bookissue->bookID] : ''?></td>
                                                    <td data-title="<?=$this->lang->line('bookissue_book_code_no')?>"><?=isset($bookcodeno[$bookissue->bookID]) ? $bookcodeno[$bookissue->bookID].'-'.$bookissue->bookno.'-'.$bookissue->booknovol.'/'.(isset($bookvols[$bookissue->bookID]) ? $bookvols[$bookissue->bookID] : '') : '' ?></td>
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
                                                <th>#</th>
                                                <th><?=$this->lang->line('member_category')?></th>
                                                <th><?=$this->lang->line('bookissue_book_code_no')?></th>
                                                <th><?=$this->lang->line('member_status')?></th>
                                                <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                                    <th><?=$this->lang->line('bookissue_action')?></th>
                                                <?php } ?>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>