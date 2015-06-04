<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 05:14:53
         compiled from "../../smarty/templates/ledger.tpl" */ ?>
<?php /*%%SmartyHeaderCode:169089955556fc2adaefd77-75986908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d79a89d1159690134e274cd5b9f89ce64b555c6' => 
    array (
      0 => '../../smarty/templates/ledger.tpl',
      1 => 1433381949,
      2 => 'file',
    ),
    '1d643d4fde4115da95a64159fde39b1561103f00' => 
    array (
      0 => '../../smarty/templates/main.tpl',
      1 => 1433356775,
      2 => 'file',
    ),
    '20f9e0d5e8cc2f2f272900656f15e2f9cc1a49dc' => 
    array (
      0 => '../../smarty/templates/header.tpl',
      1 => 1433323359,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '169089955556fc2adaefd77-75986908',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html lang="<?php echo $_smarty_tpl->getVariable('text')->value['lang'];?>
">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $_smarty_tpl->getVariable('text')->value['description'];?>
">
    <meta name="keywords" content="<?php echo $_smarty_tpl->getVariable('text')->value['keywords'];?>
">
    <meta name="author" content="<?php echo $_smarty_tpl->getVariable('text')->value['author'];?>
">
    <link type="image/x-icon" href="../favicon.ico" rel="shortcut icon">
    
    <meta property="og:image" content="<?php echo $_smarty_tpl->getVariable('text')->value['og:image'];?>
"/>
	<meta property="og:title" content="<?php echo $_smarty_tpl->getVariable('text')->value['title'];?>
"/>
	<meta property="og:url" content="<?php echo $_smarty_tpl->getVariable('text')->value['url'];?>
"/>
	<meta property="og:site_name" content="<?php echo $_smarty_tpl->getVariable('text')->value['title'];?>
"/>
	<meta property="og:type" content="website"/>

    <link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/paper/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="../fsa.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="../jquery.stickytableheaders.min.js"></script>
    <title><?php echo $_smarty_tpl->getVariable('text')->value['title'];?>
</title>
  </head>
  <body>
    <!--[if lte IE 8]>
    <div class="alert alert-danger">
      <i class="fa fa-warning"></i> <?php echo $_smarty_tpl->getVariable('text')->value['ie8'];?>

    </div>
    <![endif]-->
      <!--[if lte Opera 11]>
    <div class="alert alert-danger">
      <i class="fa fa-warning"></i> <?php echo $_smarty_tpl->getVariable('text')->value['opera11'];?>

    </div>
    <![endif]-->
  
    
  
    <?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->properties['nocache_hash']  = '169089955556fc2adaefd77-75986908';
$_tpl_stack[] = $_smarty_tpl; $_smarty_tpl = $_template;?>
<?php /* Smarty version Smarty-3.0.7, created on 2015-06-04 05:14:53
         compiled from "../../smarty/templates/header.tpl" */ ?>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
    
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">...</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../"><?php echo $_smarty_tpl->getVariable('text')->value['brand'];?>
</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if (($_smarty_tpl->getVariable('page')->value=='ledger')){?> class="active"<?php }?>><a href="../ledger/"><?php echo $_smarty_tpl->getVariable('text')->value['ledger'];?>
</a></li>
        <li <?php if (($_smarty_tpl->getVariable('page')->value=='journal')){?> class="active"<?php }?>><a href="../journal/"><?php echo $_smarty_tpl->getVariable('text')->value['journal'];?>
</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo $_smarty_tpl->getVariable('text')->value['settings_link'];?>
"><?php echo $_smarty_tpl->getVariable('text')->value['settings_address'];?>
</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php $_smarty_tpl->updateParentVariables(0);?>
<?php /*  End of included template "../../smarty/templates/header.tpl" */ ?>
<?php $_smarty_tpl = array_pop($_tpl_stack);?><?php unset($_template);?>
  <div class="container">  
    <h1><?php echo $_smarty_tpl->getVariable('text')->value['ledger'];?>
</h1>

    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

    <?php if ((count($_smarty_tpl->getVariable('filter')->value)>0)){?>
        <div class="alert alert-info">
            <h4><i class="fa fa-info-circle"></i> <?php echo $_smarty_tpl->getVariable('text')->value['filter'];?>
</h4>
            <strong><?php echo $_smarty_tpl->getVariable('text')->value['filter_explanation'];?>
</strong><br>
            <?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('filter')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['f']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['f']->iteration=0;
if ($_smarty_tpl->tpl_vars['f']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
 $_smarty_tpl->tpl_vars['f']->iteration++;
 $_smarty_tpl->tpl_vars['f']->last = $_smarty_tpl->tpl_vars['f']->iteration === $_smarty_tpl->tpl_vars['f']->total;
?>
                <?php echo $_smarty_tpl->getVariable('text')->value[$_smarty_tpl->tpl_vars['f']->key];?>
: <?php echo $_smarty_tpl->tpl_vars['f']->value;?>
<?php if (!($_smarty_tpl->tpl_vars['f']->last)){?>, <?php }?>
            <?php }} ?>
        </div>
    <?php }?>
    
    <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
    <?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable(0, null, null);?>
    <?php  $_smarty_tpl->tpl_vars['ds'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value->data; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ds']->key => $_smarty_tpl->tpl_vars['ds']->value){
?>
        <?php if (count($_smarty_tpl->tpl_vars['ds']->value)>0){?>
            <?php $_smarty_tpl->tpl_vars['accounts_name'] = new Smarty_variable("accounts_".($_smarty_tpl->tpl_vars['ds']->key), null, null);?>
            <h2><?php echo $_smarty_tpl->getVariable('text')->value[$_smarty_tpl->getVariable('accounts_name')->value];?>
</h2>
            <?php  $_smarty_tpl->tpl_vars['account'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ds']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['account']->key => $_smarty_tpl->tpl_vars['account']->value){
?>
                <h3><?php echo $_smarty_tpl->getVariable('account')->value->account->number;?>
 <?php echo $_smarty_tpl->getVariable('account')->value->account->name;?>
 
                    <?php $_smarty_tpl->tpl_vars['cs'] = new Smarty_variable($_smarty_tpl->getVariable('account')->value->sums->start+$_smarty_tpl->getVariable('account')->value->sums->debit-$_smarty_tpl->getVariable('account')->value->sums->credit, null, null);?>
                    <?php if (!(isset($_smarty_tpl->getVariable('filter',null,true,false)->value['since']))){?>
                    <small><strong><?php echo $_smarty_tpl->getVariable('text')->value['current_state'];?>
: <?php echo number_format($_smarty_tpl->getVariable('cs')->value,2);?>
</strong>, <?php echo $_smarty_tpl->getVariable('text')->value['1_1'];?>
: <?php echo number_format($_smarty_tpl->getVariable('account')->value->sums->start,2);?>
</small>
                    <?php }?>
                </h3>
                
                <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr><th><?php echo $_smarty_tpl->getVariable('text')->value['credit'];?>
<th><?php echo $_smarty_tpl->getVariable('text')->value['debit'];?>
<th><?php echo $_smarty_tpl->getVariable('text')->value['descript'];?>

                    
                  <tbody>
                    <tr class="sums">
                        <td class="number-column"><strong><?php echo number_format($_smarty_tpl->getVariable('account')->value->sums->credit,2);?>

                        <td class="number-column"><strong><?php echo number_format($_smarty_tpl->getVariable('account')->value->sums->debit,2);?>

                        <td class="third-column">
                    <tr><td colspan="3">
                        <button type="button" class="btn btn-xs" data-toggle="collapse" data-target="#collapse_<?php echo $_smarty_tpl->getVariable('j')->value;?>
"><?php echo $_smarty_tpl->getVariable('text')->value['details'];?>
</button>
                        
                    
                  <tbody id="collapse_<?php echo $_smarty_tpl->getVariable('j')->value;?>
" class="collapse out">
                        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('account')->value->rows; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
                          <?php if (!((strpos($_smarty_tpl->getVariable('row')->value->debit,'96')===0)||(strpos($_smarty_tpl->getVariable('row')->value->credit,'96')===0))){?>
                            <tr><td class="number-column"><?php if (strpos($_smarty_tpl->getVariable('row')->value->credit,$_smarty_tpl->getVariable('account')->value->account->number)===0){?><?php echo number_format($_smarty_tpl->getVariable('row')->value->amountczk,2);?>
<?php }?>
                                <td class="number-column"><?php if (strpos($_smarty_tpl->getVariable('row')->value->debit,$_smarty_tpl->getVariable('account')->value->account->number)===0){?><?php echo number_format($_smarty_tpl->getVariable('row')->value->amountczk,2);?>
<?php }?>
                                <td class="third-column"><a href="#" data-toggle="modal" data-target="#modal_<?php echo $_smarty_tpl->getVariable('i')->value;?>
"><?php echo $_smarty_tpl->getVariable('row')->value->date;?>
 <?php echo $_smarty_tpl->getVariable('row')->value->description;?>
</a>
                                
                                <div class="modal fade" id="modal_<?php echo $_smarty_tpl->getVariable('i')->value;?>
" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4><?php echo $_smarty_tpl->getVariable('text')->value['details'];?>
</h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['row']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
                                          <?php $_smarty_tpl->tpl_vars['item_name'] = new Smarty_variable("case_".($_smarty_tpl->tpl_vars['item']->key), null, null);?>
                                          <strong><?php echo $_smarty_tpl->getVariable('text')->value[$_smarty_tpl->getVariable('item_name')->value];?>
</strong>:
                                          <?php if (strpos($_smarty_tpl->tpl_vars['item']->value,'http')===0){?><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
" target="_blank"><?php }?> <?php echo $_smarty_tpl->tpl_vars['item']->value;?>

                                          <?php if (strpos($_smarty_tpl->tpl_vars['item']->value,'http')===0){?></a><?php }?>
                                          <br>
                                        <?php }} ?>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $_smarty_tpl->getVariable('text')->value['close'];?>
</button>
                                      </div>
                                    </div>
                                  </div>
                                <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
                          <?php }?>
                        <?php }} ?>
                    </tbody>
                    <tbody>
                        <tr><td colspan="3"><button type="button" class="btn btn-xs" data-toggle="collapse" data-target="#collapse_monthly_<?php echo $_smarty_tpl->getVariable('j')->value;?>
"><?php echo $_smarty_tpl->getVariable('text')->value['monthly'];?>
</button>
                    <tbody id="collapse_monthly_<?php echo $_smarty_tpl->getVariable('j')->value;?>
" class="collapse out">
                        <?php  $_smarty_tpl->tpl_vars['month'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('account')->value->months; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['month']->key => $_smarty_tpl->tpl_vars['month']->value){
?>
                            <tr><td class="number-column"><?php echo number_format($_smarty_tpl->getVariable('month')->value->credit,2);?>

                                <td class="number-column"><?php echo number_format($_smarty_tpl->getVariable('month')->value->debit,2);?>

                                <?php $_smarty_tpl->tpl_vars['m'] = new Smarty_variable("month_".($_smarty_tpl->tpl_vars['month']->key), null, null);?>
                                <td class="third-column"><?php echo $_smarty_tpl->getVariable('text')->value[$_smarty_tpl->getVariable('m')->value];?>

                        <?php }} ?> 
                    </tbody>
                    <?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable($_smarty_tpl->getVariable('j')->value+1, null, null);?>
                </table>
                </div>
            <?php }} ?>
        <?php }?>
    <?php }} ?>


        </div>
      </div>
    </div>
    
  </div>

    <?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    
    <!-- google analytics -->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', "<?php echo $_smarty_tpl->getVariable('text')->value['google_tracking_id'];?>
"]);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <!-- /google analytics -->
  </body>
</html>
