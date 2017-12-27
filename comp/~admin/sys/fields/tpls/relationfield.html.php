<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Fields"])){ require_once(file_exists("do/FieldsAct.class.php")?"do/FieldsAct.class.php":"~do/FieldsAct.class.php"); Action::$classqueue["Fields"] = new FieldsAct(); }Action::$classqueue["Fields"]->getlivs();Action::$classqueue["Fields"]->getfieldinfo();?>
<div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span>表单管理 -- 新增字段</span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" valurl="fieldparenturl" chvalurl="url">实例列表</a>
	<a href="javascript:;" class="button" brurl="sys/fields/?app/id/<?php echo Template::$_tplval['info']['id']; ?>.html">表单管理</a>
</div>
<?php if(empty(Action::$classqueue["Fields"])){ require_once(file_exists("do/FieldsAct.class.php")?"do/FieldsAct.class.php":"~do/FieldsAct.class.php"); Action::$classqueue["Fields"] = new FieldsAct(); }Action::$classqueue["Fields"]->gettables();?>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="sys/fields/do/?Fields-<?php echo Template::$_tplval['actinfo']; ?>.html" fun="sysfieldsrelationfield">
	  <fieldset style="width:500px;">
	  <?php echo Template::$_tplval['fieldata']; ?>
	  <legend>关联表“<?php echo Template::$_tplval['info']['livname']; ?>(<?php echo Template::$_tplval['info']['proname']; ?>)”</legend>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="500">
		    <label text="字段标签">字段标签</label>
			<input type="text" name="fieldlabel" dataType="Require" itip="请填写字段标签" />
			<input name="xtype" type="hidden" value="relationfield" class="noload"/>
			<input name="appid" type="hidden" value="<?php echo Template::$_tplval['info']['id']; ?>" />
		  </td>
        </tr>
        <tr>
          <td width="500">
		    <label text="字段名">字段名</label>
			<input type="text" name="name" dataType="EngNumDl" itip="字段名只能是英文,数字或者下划线" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label text="表单列">表单列</label>
			<input type="text" name="colspan" dataType="Number" value="1" itip="表单列只能填写数字" />
			<input name="rowspan" type="hidden" value="1" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label text="列表宽">列表宽</label>
			<input type="text" name="listwidth" dataType="Number" value="50" itip="列表宽只能填写数字" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label text="关联表">关联表</label>
			<select name="relationtable" dataType="Require" itip="请选择关联表" onchange="selectfields(this.value)">
				<option value="">选择关联表</option>
				<?php $_from = Template::$_tplval['tableslist']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
				<option value="<?php echo Template::$_tplval['list']; ?>"><?php echo Template::$_tplval['list']; ?></option>
				<?php }} unset($_from);?>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label text="关联显示字段">关联显示字段</label>
			<select name="relationfield" dataType="Require" itip="请选择关联显示字段" id="sys-fields-relationfield">
				<option value="">选择关联显示字段</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>关联字段分类(__typeid的值)</label>
			<label>当关联表为mx_menu时:不含分隔","时为parent_id值,含分隔","时为mx_menu的ID</label>
			<input type="text" name="relationtypeid" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>关联排序字段</label>
			<select name="relationfieldsortfd" id="sys-fields-relationfieldsortfd">
				<option value="">请选择关联排序字段</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>关联排序方式</label>
			<select name="relationfieldsortinfo">
				<option value="">选择关联排序方式</option>
				<option value="ASC">正序(ASC)</option>
				<option value="DESC">倒序(DESC)</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>关联显示方式</label>
			<select name="relationfieldistype" id="sys-fields-relationfieldistype">
				<option value="0">下拉选择</option>
				<option value="1">多项选择</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>关联显示行列(多项选择)</label>
			<input type="text" name="columns" value="1" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>联动级别</label>
			<select name="relationfieldldgrade">
				<option value="">联动级别</option>
				<option value="1">第一级</option>
				<option value="2">第二级</option>
				<option value="3">第三级</option>
				<option value="4">第四级</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>验证类型</label>
			<select name="datatype">
				<option value="Require">必须填写</option>
				<option value="">无</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>搜索选项</label>
			<select name="issearch">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>全站搜索</label>
			<select name="sitesearch">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>是否必填项</label>
			<select name="_require">
				<option value="1">是</option>
				<option value="0">否</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>是否可修改(只对列表模型有用)</label>
			<select name="abledit">
				<option value="1" selected="selected">是</option>
				<option value="0">否</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label text="排序">排序</label>
			<input type="text" name="sort" dataType="Number" value="<?php  echo $_GET['sort'];  ?>" itip="排序只能填写数字" />
			<input name="displaytag" type="hidden" value="1" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>当__typeid(分类标识)为该值(多值请用逗号分隔)时隐藏该字段</label>
			<input type="text" name="eqtypeval" />
		  </td>
        </tr>
		<tr>
          <td width="500" class="mx-form-submit">
		    <input type="submit" name="submitButton" value="提　交" />
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>
<script type="text/javascript">
//当修改加载
function sysfieldsrelationfield(d)
{
	selectfields(d.relationtable,d.relationfield,d.relationfieldsortfd);
}
//选择关联表时显示对应的字段
function selectfields(v,fd,sortfd)
{
	$.post("sys/fields/do/?Fields-getfields.html",{tname:v},function(text){
		var ed = text.split(","),
			edlen = ed.length;
		var option = document.getElementById("sys-fields-relationfield");
		var optsort = document.getElementById("sys-fields-relationfieldsortfd");
		for(var i=0;i<edlen;i++){
			option.options[i+1] = new Option(ed[i],ed[i]);
			if(fd==ed[i]) option.options[i+1].selected = true;
			optsort.options[i+1] = new Option(ed[i],ed[i]);
			if(sortfd==ed[i]) optsort.options[i+1].selected = true;
		}
	});
}
</script>