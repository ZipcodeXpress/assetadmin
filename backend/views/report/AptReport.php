<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Search Condition</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="index.php?r=organization-report/index" method="POST" class="form-inline">
                           <div class="form-group">
                              <label class="control-label" for="begin_time">Begin Time</label> <input id="begin_time" name="begin_time" value="<?=$begin_time?>" class="laydate-icon form-control layer-date" required="required">                    
                          </div>
                           <div class="form-group">
                              <label class="control-label" for="end_time">End Time</label> <input id="end_time" name="end_time"  value="<?=$end_time?>" class="laydate-icon form-control layer-date" required="required">                    
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Search</button>                        
                          </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
       <?php foreach($organizations_reports as $key=>$organizations):?>  
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Organization [<?=$key?>] Amount</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Organization</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(empty($organizations['charges_amount'])):?>
                            <td><h4>No records found</h4></td>
                            <?php else: ?>
                                  <?php foreach($organizations['charges_amount'] as $r):?>
                                    <tr>
                                         <tr>
                                            <td><?=$r['email']?></td>
                                            <td><?=$r['phone']?></td>
                                            <td><?=$r['organization_name']?></td>
                                            <td class="text-navy">  <?=$r['amount']?></td>
                                        </tr>
                                    </tr>
                                 <?php endforeach;?>
                           <?php endif ?>
                            </tbody>
                        </table>
                        <?php if(!empty($organizations['charges_amount'])):?>
                         <form action="index.php?r=organization-report/export-amount" method="POST" class="form-inline">
                           <div class="form-group">
                             <input type="hidden" name="charges_amount_export" value='<?=json_encode($organizations['charges_amount'])?>'>                    
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Export</button>                       
                          </div>
                        </form>   
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Organization [<?=$key?>] Details</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Charge ID</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Organization</th>
                                    <th>Charge Type</th>
                                    <th>Charge Channel</th>
                                    <th>Amount</th>
                                    <th>Paid Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(empty($organizations['charges_details'])):?>
                            <td><h4>No records found</h4></td>
                            <?php else: ?>
                                 <?php foreach($organizations['charges_details'] as $r):?>
                                    <tr>
                                         <tr>
                                            <td class="text-navy">  <?=$r['charge_id']?></td>
                                            <td><?=$r['email']?></td>
                                            <td><?=$r['phone']?></td>
                                            <td><?=$r['organization_name']?></td>
                                            
                                            <td><?=$r['charge_type']?></td>
                                            <td><?=$r['charge_channel']?></td>
                                            <td><?=$r['amount']?></td>
                                            <td class="text-navy">  <?=$r['paid_time']?></td>
                                        </tr>
                                    </tr>
                                 <?php endforeach;?>
                             <?php endif ?>
                            </tbody>
                        </table>
                        <?php if(!empty($organizations['charges_details'])):?>
                         <form action="index.php?r=organization-report/export-details" method="POST" class="form-inline">
                           <div class="form-group">
                             <input type="hidden" name="charges_details_export" value='<?=json_encode($organizations['charges_details'])?>'>                    
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Export</button>                       
                          </div>
                        </form>
                         <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
       <?php endforeach;?>
    </div>
<script src="js/plugins/layer/laydate/laydate.js"></script>
<script>
var start = {
    elem: "#begin_time",
    format: "YYYY/MM/DD",
    min: '1970-01-01',
    max: "2099-06-16",
    istime: false,
    istoday: true,
    choose: function(datas) {
        end.min = datas;
        end.start = datas
    }
};
var end = {
    elem: "#end_time",
    format: "YYYY/MM/DD",
    min: '1970-01-01',
    max: "2099-06-16",
    istime: false,
    istoday: true,
    choose: function(datas) {
        start.max = datas
    }
};
laydate(start);
laydate(end);
</script>