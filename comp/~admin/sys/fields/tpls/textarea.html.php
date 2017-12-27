<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Fields"])){ require_once(file_exists("do/FieldsAct.class.php")?"do/FieldsAct.class.php":"~do/FieldsAct.class.php"); Action::$classqueue["Fields"] = new FieldsAct(); }Action::$classqueue["Fields"]->getlivs();Action::$classqueue["Fields"]->getfieldinfo();?>
<div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span>表单管理 -- 新增字段</span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" valurl="fieldparenturl" chvalurl="url">实例列表</a>
	<a href="javascript:;" class="button" brurl="sys/fields/?app/id/<?php echo Template::$_tplval['info']['id']; ?>.html">表单管理</a>
</div>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="sys/fields/do/?Fields-<?php echo Template::$_tplval['actinfo']; ?>.html">
	  <fieldset style="width:300px;">
	  <?php echo Template::$_tplval['fieldata']; ?>
	  <legend>文本域“<?php echo Template::$_tplval['info']['livname']; ?>(<?php echo Template::$_tplval['info']['proname']; ?>)”</legend>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="300">
		    <label text="字段标签">字段标签</label>
			<input type="text" name="fieldlabel" dataType="Require" itip="请填写字段标签" />
			<input name="xtype" type="hidden" value="textarea" class="noload"/>
			<input name="appid" type="hidden" value="<?php echo Template::$_tplval['info']['id']; ?>" />
		  </td>
        </tr>
        <tr>
          <td width="300">
		    <label text="字段名">字段名</label>
			<input type="text" name="name" dataType="EngNumDl" itip="字段名只能是英文,数字或者下划线" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="表单行">表单行</label>
			<input type="text" name="rowspan" dataType="Number" value="1" itip="表单行只能填写数字" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="表单列">表单列</label>
			<input type="text" name="colspan" dataType="Number" value="1" itip="表单列只能填写数字" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="高">高</label>
			<input type="text" name="height" dataType="Number" value="50" itip="文本域的高只能填写数字" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="列表宽">列表宽</label>
			<input type="text" name="listwidth" dataType="Number" value="50" itip="列表宽只能填写数字" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>验证类型</label>
			<select name="datatype">
				<?php $_from = Template::$_tplval['datatype']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
				<option value="<?php echo Template::$_tplval['list']['val']; ?>"><?php echo Template::$_tplval['list']['text']; ?></option>
				<?php }} unset($_from);?>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>是否必填项</label>
			<select name="_require">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>是否可修改(只对列表模型有用)</label>
			<select name="abledit">
				<option value="1" selected="selected">是</option>
				<option value="0">否</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>默认值</label>
			<input type="text" name="defval" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>是否是唯一值</label>
			<select name="onlyone">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>新增默认数据类型</label>
			<select name="datafilltype">
				<option value="">请选择新增默认数据类型</option>
				<?php echo Template::$_tplval['datadefstring']; ?>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>搜索选项</label>
			<select name="issearch">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>全站搜索</label>
			<select name="sitesearch">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>补丁(JS类)</label>
			<input type="text" name="fdplusfn" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="排序">排序</label>
			<input type="text" name="sort" dataType="Number" value="<?php  echo $_GET['sort'];  ?>" itip="排序只能填写数字" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>提交方式</label>
			<div class="datalist" col="2">
				<span><input class="groupdata" name="displaytag" type="radio" value="1" checked="checked"/><em>表单提交</em></span>
				<span><input class="groupdata" name="displaytag" type="radio" value="0"/><em>隐藏</em></span>
			</div>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>当__typeid(分类标识)为该值(多值请用逗号分隔)时隐藏该字段</label>
			<input type="text" name="eqtypeval" />
		  </td>
        </tr>
		<tr>
          <td width="300" class="mx-form-submit">
		    <input type="submit" name="submitButton" value="提　交" />
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>