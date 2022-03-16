
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