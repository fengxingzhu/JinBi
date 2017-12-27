<?php
/**
 * 表单字段模板
 */
class FieldFormTpl
{
	private function validate($d)
	{
		$valil = ''; $msg = '';
		switch ($d['datatype']){
			case 'Require': $msg = $d['fieldlabel'].'必须填写'; break;
			case 'English': $msg = $d['fieldlabel'].'只能填写英文'; break;
			case 'Number': $msg = $d['fieldlabel'].'只能填写数字'; break;
			case 'Integer': $msg = $d['fieldlabel'].'只能填写整数'; break;
			case 'EngNum': $msg = $d['fieldlabel'].'只能填写英文和数字'; break;
			case 'Chinese': $msg = $d['fieldlabel'].'只能填写中文'; break;
			case 'Phone': $msg = $d['fieldlabel'].'填写错误'; break;
			case 'Email': $msg = $d['fieldlabel'].'填写错误'; break;
		}
		if(!empty($d['datatype']) && $d['eqtypeval']==''){
			$valil = ' require="'.($d['_require']==0?'false':'true').'" dataType="'.$d['datatype'].'" itip="'.$msg.'"';
		}
		return $valil;
	}
	/**
	 * 文本
	 * @param array $d 字段相关属性值
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function textfield($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			';
		}else{
			$val = $d['defval'];
			if(substr($val,0,4)=='USER'){
				$user = Cache::session_get('MXUSER_INFO');
				$ev = explode('.',$d['defval']);
				$val = $user[$ev[1]];//发布者
			}
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<input type="text" name="'.$d['name'].'"'.$this->validate($d).' value="'.$val.'" fdplusfn="'.$d['fdplusfn'].'" />
			';
		}
	}
	/**
	 * 整数文本
	 * @param array $d 字段相关属性值
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function integralfield($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			';
		}else{
			$val = $d['defval'];
			if(substr($val,0,4)=='USER'){
				$user = Cache::session_get('MXUSER_INFO');
				$ev = explode('.',$d['defval']);
				$val = $user[$ev[1]];//发布者ID
			}
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<input type="text" name="'.$d['name'].'"'.$this->validate($d).' value="'.$val.'" fdplusfn="'.$d['fdplusfn'].'" />
			';
		}
	}
	/**
	 * 文本域
	 * @param array $d 字段相关属性值
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function textarea($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<textarea name="'.$d['name'].'" style="display:none;">'.$val.'</textarea>
			';
		}else{
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<textarea name="'.$d['name'].'"'.$this->validate($d).' style="height:'.$d['height'].'px;" fdplusfn="'.$d['fdplusfn'].'">'.$d['defval'].'</textarea>
			';
		}
	}
	/**
	 * 时间字段
	 * @param array $d 字段相关属性值
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function datefield($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			';
		}else{
			$ptype = array('yyyy','MM','dd','HH','mm','ss');
			$ctype = array('Y','m','d','H','i','s');
			$format = str_replace($ptype,$ctype,$d['datefmt']);
			$val = $d['defval']=='NOW'?date($format):'';
			
			$validate = '';
			if($d['_require']=='1' && $d['eqtypeval']==''){
				$validate = ' dataType="Require"  itip="'.$d['fieldlabel'].'必须选择"';
			}
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<input type="text" name="'.$d['name'].'"'.$validate.' class="Wdate" onFocus="WdatePicker({dateFmt:\''.$d['datefmt'].'\'})" value="'.$val.'" fdplusfn="'.$d['fdplusfn'].'" />
			';
		}
	}
	/**
	 * 单选
	 * @param array $d 字段相关属性值
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function radiogroup($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			<input type="hidden" name="'.$d['name'].'_key" value="'.Template::$_tplval['info'][$d['name'].'_key'].'" />
			';
		}else{
			//读取单选数据
			$m = new Model();
			$radio = $m->get_all('SELECT * FROM '.DB_MX_PRE.'fieldatas WHERE fieldid="'.$d['id'].'" ORDER BY sort ASC');
			$input = array(); $defaultinput = '';
			foreach ($radio as $k=>$kl){
				$checked = '';
				if($kl['isdef']==1){
					$checked = ' checked="checked"';
					$defaultinput = $kl['keyinfo'];
				}
				$lastcheck = '';
				if($d['_require']=='1' && $d['eqtypeval']==''){
					$lastcheck = ' dataType="Group"  itip="'.$d['fieldlabel'].'必须选择"';
				}
				array_push($input,'<span><input class="groupdata" name="'.$d['name'].'" type="radio" value="'.$kl['valinfo'].'" keyid="'.$kl['keyinfo'].'"'.$checked.' /><em>'.$kl['valinfo'].'</em></span>');
			}
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div class="datalist" name="'.$d['name'].'" col="'.$d['columns'].'"'.$lastcheck.' fdplusfn="'.$d['fdplusfn'].'">'.join('',$input).'</div>
			<input name="'.$d['name'].'_key" type="hidden" value="'.$defaultinput.'" />
			';
			return $vstr;
		}
	}
	/**
	 * 多选
	 * @param array $d 字段相关属性值
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function checkboxgroup($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			<input type="hidden" name="'.$d['name'].'_key" value="'.Template::$_tplval['info'][$d['name'].'_key'].'" />
			';
		}else{
			//读取多选数据
			$m = new Model();
			$radio = $m->get_all('SELECT * FROM '.DB_MX_PRE.'fieldatas WHERE fieldid="'.$d['id'].'" ORDER BY sort ASC');
			$input = array(); $defaultn = array(); $defaultinput = array();
			foreach ($radio as $k=>$kl){
				$checked = '';
				if($kl['isdef']==1){
					$checked = ' checked="checked"';
					array_push($defaultn,$kl['valinfo']);
					array_push($defaultinput,$kl['keyinfo']);
				}
				$lastcheck = '';
				if($d['_require']=='1' && $d['eqtypeval']==''){
					$lastcheck = ' dataType="Group"  itip="'.$d['fieldlabel'].'必须选择"';
				}
				array_push($input,'<span><input class="groupdata" name="'.$d['name'].'s[]" type="checkbox" value="'.$kl['valinfo'].'" keyid="'.$kl['keyinfo'].'"'.$checked.'/><em>'.$kl['valinfo'].'</em></span>');
			}
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div class="datalist" name="'.$d['name'].'s[]" col="'.$d['columns'].'"'.$lastcheck.' fdplusfn="'.$d['fdplusfn'].'">'.join('',$input).'</div>
			<input name="'.$d['name'].'" type="hidden" value="'.join(',',$defaultn).'" />
			<input name="'.$d['name'].'_key" type="hidden" value="'.join(',',$defaultinput).'" />
			';
			return $vstr;
		}
	}
	/**
	 * 下拉选择
	 * @param array $d
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function combo($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			<input type="hidden" name="'.$d['name'].'_key" value="'.Template::$_tplval['info'][$d['name'].'_key'].'" />
			';
		}else{
			//读取下拉选择数据
			$m = new Model();
			$radio = $m->get_all('SELECT * FROM '.DB_MX_PRE.'fieldatas WHERE fieldid="'.$d['id'].'" ORDER BY sort ASC');
			$input = array(); $defaultinput = '';
			foreach ($radio as $k=>$kl){
				$selected = '';
				if($kl['isdef']==1){
					$selected = ' selected="selected"';
					$defaultinput = $kl['keyinfo'];
				}
				array_push($input,'<option value="'.$kl['valinfo'].'" keyid="'.$kl['keyinfo'].'"'.$selected.'>'.$kl['valinfo'].'</option>');
			}
			$validate = '';
			if($d['_require']=='1' && $d['eqtypeval']==''){
				$validate = ' dataType="Require"  itip="'.$d['fieldlabel'].'必须选择"';
			}
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<select name="'.$d['name'].'" fdplusfn="'.$d['fdplusfn'].'"'.$validate.'>'.join('',$input).'</select>
			<input name="'.$d['name'].'_key" type="hidden" value="'.$defaultinput.'" />
			';
			return $vstr;
		}
	}
	/**
	 * 单文件上传
	 * @param array $d
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function simpleupload($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			<input type="hidden" name="'.$d['name'].'_path" value="'.Template::$_tplval['info'][$d['name'].'_path'].'" />
			';
		}else{
			$validator = '';
			if($d['_require']=='1' && $d['eqtypeval']==''){
				$validator = ' dataType="Require"  itip="请上传文件!"';
			}
			//图像配置信息
			$m = new Model();
			$picid = $m->get_row('SELECT id FROM '.DB_MX_PRE.'fieldupload WHERE fieldid="'.$d['id'].'"');
			$picid = empty($picid['id'])?0:$picid['id'];
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<input type="text" name="'.$d['name'].'"'.$this->validate($d).' id="mx-form-upload-'.$d['id'].'" class="mx-fileupload" readonly="true"'.$validator.'  fdplusfn="'.$d['fdplusfn'].'"/><span id="mx-form'.$d['name'].'-div"><img src="images/simpleupload.png" fid="'.$d['id'].'" picid="'.$picid.'" class="mx-formsimpleup-img" id="mx-form'.$d['name'].'" fieldname="'.$d['name'].'" align="absmiddle"/></span><img src="images/upfilemanimg.png" fid="'.$d['id'].'" nid="'.$_GET['id'].'" ag="'.$_GET['ag'].'" tp="'.$_GET['tp'].'" class="mx-fileupload-simpleimg" align="absmiddle" />
			<input type="hidden" name="'.$d['name'].'_path" id="mx-form-simpleuploadids-'.$d['id'].'" />
			';
			return $vstr;
		}
	}
	/**
	 * 多文件上传
	 * @param array $d
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function fileupload($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			<input type="hidden" name="'.$d['name'].'_ids" value="'.Template::$_tplval['info'][$d['name'].'_ids'].'" />
			';
		}else{
			$validator = '';
			if($d['_require']=='1' && $d['eqtypeval']==''){
				$validator = ' dataType="Require"  itip="请上传文件!"';
			}
			//图像配置信息
			$m = new Model();
			$picid = $m->get_row('SELECT id FROM '.DB_MX_PRE.'fieldupload WHERE fieldid="'.$d['id'].'"');
			$picid = empty($picid['id'])?0:$picid['id'];
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<input type="text" name="'.$d['name'].'"'.$this->validate($d).' id="mx-form-upload-'.$d['id'].'" class="mx-fileupload" readonly="true"'.$validator.'  fdplusfn="'.$d['fdplusfn'].'"/><img src="images/upload.png" fid="'.$d['id'].'" picid="'.$picid.'" class="mx-formup-img" align="absmiddle"/><img src="images/upfilemanimg.png" fid="'.$d['id'].'" ag="'.$_GET['ag'].'" tp="'.$_GET['tp'].'" class="mx-fileupload-imglist" align="absmiddle" />
			<input type="hidden" name="'.$d['name'].'_ids" id="mx-form-uploadids-'.$d['id'].'" />
			';
			return $vstr;
		}
	}
	/**
	 * ewebeditor编辑器
	 * @param array $d
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function ewebeditor($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<textarea name="'.$d['name'].'" style="display:none;">'.$val.'</textarea>
			';
		}else{
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<textarea name="'.$d['name'].'" style="display:none;">'.$d['defval'].'</textarea>
			<iframe src="../~editor/eweditor/ewebeditor.htm?id='.$d['name'].'&style=coolblue" frameborder="0" scrolling="no" width="100%" height="'.$d['height'].'"></iframe>
			';
			return $vstr;
		}
	}
	/**
	 * ckeditor编辑器
	 * @param array $d
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function ckeditor($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<textarea name="'.$d['name'].'" style="display:none;">'.$val.'</textarea>
			';
		}else{
			$toolbar = $d['toolbar']!='default'?'&Toolbar='.$d['toolbar']:'';
			$val = Template::$_tplval['info'][$d['name']];
			$val =  empty($val)?$d['defval']:$val;
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<textarea name="'.$d['name'].'" id="__ckeditor_'.$d['id'].'" style="display:none;" class="noload" edit="ckeditor">'.$val.'</textarea>
			';
			return $vstr;
		}
	}
	/**
	 * 标识字段
	 * @param array $d
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function markfield($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			<input type="hidden" name="'.$d['name'].'_key" value="'.Template::$_tplval['info'][$d['name'].'_key'].'" />
			';
		}else{
			$vstr = '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div class="datalist" col="2">
				<span><input class="groupdata" name="'.$d['name'].'" type="radio" keyid="0" value="否" checked="checked"/><em>否</em></span>
				<span><input class="groupdata" name="'.$d['name'].'" type="radio" keyid="1" value="是" /><em>是</em></span>
			</div>
			<input name="'.$d['name'].'_key" type="hidden" value="" />
			';
			return $vstr;
		}
	}
	/**
	 * 关联字段
	 * @param array $d
	 * @param bool $isedit 是否是修改表单 默认为false
	 */
	public function relationfield($d,$isedit = false)
	{
		if($isedit && $d['abledit']==0){//不能修改状态
			$val = Template::$_tplval['info'][$d['name']];
			return '
			<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
			<div>'.$val.'</div>
			<input type="hidden" name="'.$d['name'].'" value="'.$val.'" />
			<input type="hidden" name="'.$d['name'].'_key" value="'.Template::$_tplval['info'][$d['name'].'_key'].'" />
			';
		}else{
			$m = new Model();
			//读取关联信息
			$sortfd = empty($d['relationfieldsortfd'])?'id':$d['relationfieldsortfd'];//关联排序字段
			$sortway = empty($d['relationfieldsortinfo'])?'DESC':$d['relationfieldsortinfo'];//关联排序字段排序方式
			$typeid = empty($d['relationtypeid'])?'':' AND __typeid="'.$d['relationtypeid'].'"';//关联的类别
			$vstr = '<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>';
			if(empty($d['relationfieldldgrade'])){//无联动
				$data = $m->get_all('SELECT id,'.$d['relationfield'].' FROM '.$d['relationtable'].' WHERE 1'.$typeid.' ORDER BY '.$sortfd.' '.$sortway.'');//读取关联表信息
				if($d['relationfieldistype']==0){//单选
					$options = '<option value="" keyid="">请选择'.$d['fieldlabel'].'</option>';
					foreach($data as $list){
						$options .= '<option value="'.$list[$d['relationfield']].'" keyid="'.$list['id'].'">'.$list[$d['relationfield']].'</option>';
					}
					$vstr .= '<select name="'.$d['name'].'"'.$this->validate($d).'>'.$options.'</select>';
					$vstr .= '<input type="hidden" name="'.$d['name'].'_key" />';
				}else{//多选
					$input = array(); $defaultn = array(); $defaultinput = array();
					foreach ($data as $k=>$kl){
						$lastcheck = '';
						if($d['_require']=='1' && $d['eqtypeval']==''){
							$lastcheck = ' dataType="Group"  itip="'.$d['fieldlabel'].'必须选择"';
						}
						array_push($input,'<span><input class="groupdata" name="'.$d['name'].'s[]" type="checkbox" value="'.$kl[$d['relationfield']].'" keyid="'.$kl['id'].'"/><em>'.$kl[$d['relationfield']].'</em></span>');
					}
					$vstr .= '
					<div class="datalist" name="'.$d['name'].'s[]" col="'.$d['columns'].'"'.$lastcheck.'>'.join('',$input).'</div>
					<input name="'.$d['name'].'" type="hidden" value="" />
					<input name="'.$d['name'].'_key" type="hidden" value="" />
					';
				}
			}else{//有联动
				//读取下级联动字段
				$dfields = $m->get_all('SELECT name FROM '.DB_MX_PRE.'fields WHERE appid="'.$d['appid'].'" AND relationfieldldgrade='.($d['relationfieldldgrade']+1).' ORDER BY sort ASC');
				$downames = array();
				foreach($dfields as $df) array_push($downames, $df['name']);
				$dfielstr = empty($downames)?'':' downfields="'.join(',', $downames).'"';
				if($d['relationfieldldgrade']<2){//一级
					if($d['relationtable']==DB_MX_PRE.'menu'){//后台菜单
						$firstsql = strpos($d['relationtypeid'], ',')?'SELECT * FROM '.DB_MX_PRE.'menu WHERE id IN('.$d['relationtypeid'].') ORDER BY sort ASC'://固定几个值
										'SELECT * FROM '.DB_MX_PRE.'menu WHERE parent_id="'.$d['relationtypeid'].'" ORDER BY sort ASC';//按parent_id来关联
					}else{
						$firstsql = 'SELECT id,'.$d['relationfield'].' FROM '.$d['relationtable'].' WHERE 1'.$typeid.' ORDER BY '.$sortfd.' '.$sortway.'';
					}
					$data = $m->get_all($firstsql);//读取关联表信息
					$options = '';
					foreach($data as $list){
						$options .= '<option value="'.$list[$d['relationfield']].'" keyid="'.$list['id'].'">'.$list[$d['relationfield']].'</option>';
					}
					$vstr .= '<select name="'.$d['name'].'"'.$this->validate($d).$dfielstr.'><option value="" keyid="">请选择'.$d['fieldlabel'].'</option>'.$options.'</select>';
				}else{//下一级
					//读取上级的APPID
					$parentappid = $m->get_row('SELECT id FROM '.DB_MX_PRE.'applivs WHERE dbtname="'.$d['relationtable'].'"');
					//读取上一级字段名称
					$parentfdname = $m->get_row('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$parentappid['id'].'" AND relationfieldldgrade='.($d['relationfieldldgrade']-1).'');
					if($parentfdname['relationtable']==DB_MX_PRE.'menu'){//读取菜单信息
						//读取父级信息
						$menusql = strpos($parentfdname['relationtypeid'], ',')?'SELECT id FROM '.DB_MX_PRE.'menu WHERE id IN('.$parentfdname['relationtypeid'].') ORDER BY sort ASC':
													'SELECT id FROM '.DB_MX_PRE.'menu WHERE parent_id="'.$parentfdname['relationtypeid'].'" ORDER BY sort ASC';
						$menuids = $m->get_all($menusql);
						$menutemp = array();
						foreach($menuids as $list) array_push($menutemp, $list['id']);
						$data = empty($menutemp)?array():$m->get_all('SELECT id,'.$d['relationfield'].',__typeid FROM '.$d['relationtable'].' WHERE __typeid IN('.join(',', $menutemp).') ORDER BY '.$sortfd.' '.$sortway.'');
						$options = '';
						foreach($data as $list){
							$options .= '<option value="'.$list[$d['relationfield']].'" keyid="'.$list['id'].'" parentkey="'.$list['__typeid'].'">'.$list[$d['relationfield']].'</option>';
						}
					}else{
						$data = $m->get_all('SELECT id,'.$d['relationfield'].','.$parentfdname['name'].'_key FROM '.$d['relationtable'].' WHERE 1'.$typeid.' ORDER BY '.$sortfd.' '.$sortway.'');//读取关联表信息
						$options = '';
						foreach($data as $list){
							$options .= '<option value="'.$list[$d['relationfield']].'" keyid="'.$list['id'].'" parentkey="'.$list[$parentfdname['name'].'_key'].'">'.$list[$d['relationfield']].'</option>';
						}
					}
					$vstr .= '<select name="'.$d['name'].'"'.$this->validate($d).$dfielstr.'><option value="" keyid="">请选择'.$d['fieldlabel'].'</option></select>';
					$vstr .= '<select name="'.$d['name'].'__data" class="gradesearchfieldata">'.$options.'</select>';
				}
				$vstr .= '<input type="hidden" name="'.$d['name'].'_key" />';
			}
			return $vstr;
		}
	}
}
?>