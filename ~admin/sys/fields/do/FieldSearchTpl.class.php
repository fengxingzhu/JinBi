<?php
/**
 * 表单字段模板
 */
class FieldFormTpl
{
	/**
	 * 文本
	 * @param array $d 字段相关属性值
	 */
	public function textfield($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 整数文本
	 * @param array $d 字段相关属性值
	 */
	public function integralfield($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 文本域
	 * @param array $d 字段相关属性值
	 */
	public function textarea($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 时间字段
	 * @param array $d 字段相关属性值
	 */
	public function datefield($d)
	{
		$ptype = array('yyyy','MM','dd','HH','mm','ss');
		$ctype = array('Y','m','d','H','i','s');
		$format = str_replace($ptype,$ctype,$d['datefmt']);
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		开始:<input type="text" name="'.$d['name'].'[]" class="Wdate noauto" onFocus="WdatePicker({dateFmt:\''.$d['datefmt'].'\'})" />结束:<input type="text" name="'.$d['name'].'[]" class="Wdate noauto" onFocus="WdatePicker({dateFmt:\''.$d['datefmt'].'\'})" />
		';
	}
	/**
	 * 单选
	 * @param array $d 字段相关属性值
	 */
	public function radiogroup($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 多选
	 * @param array $d 字段相关属性值
	 */
	public function checkboxgroup($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 下拉选择
	 * @param array $d
	 */
	public function combo($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 单文件上传
	 * @param array $d
	 */
	public function simpleupload($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 多文件上传
	 * @param array $d
	 */
	public function fileupload($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * ewebeditor编辑器
	 * @param array $d
	 */
	public function ewebeditor($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * ckeditor编辑器
	 * @param array $d
	 */
	public function ckeditor($d)
	{
		return '
		<label text="'.$d['fieldlabel'].'">'.$d['fieldlabel'].'</label>
		<input type="text" name="'.$d['name'].'" />
		';
	}
	/**
	 * 标识字段
	 * @param array $d
	 */
	public function markfield($d)
	{
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
	/**
	 * 关联字段
	 * @param array $d
	 */
	public function relationfield($d)
	{
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
				$vstr .= '<select name="'.$d['name'].'">'.$options.'</select>';
				$vstr .= '<input type="hidden" name="'.$d['name'].'_key" />';
			}else{//多选
				$input = array(); $defaultn = array(); $defaultinput = array();
				foreach ($data as $k=>$kl){
					array_push($input,'<span><input class="groupdata" name="'.$d['name'].'s[]" type="checkbox" value="'.$kl[$d['relationfield']].'" keyid="'.$kl['id'].'"/><em>'.$kl[$d['relationfield']].'</em></span>');
				}
				$vstr = '
				<div class="datalist" name="'.$d['name'].'s[]" col="'.$d['columns'].'">'.join('',$input).'</div>
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
				$vstr .= '<select name="'.$d['name'].'"'.$dfielstr.'><option value="" keyid="">请选择'.$d['fieldlabel'].'</option>'.$options.'</select>';
			}else{//下一级
				//读取上一级字段名称
				$parentfdname = $m->get_row('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$d['appid'].'" AND relationfieldldgrade='.($d['relationfieldldgrade']-1).'');
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
				$vstr .= '<select name="'.$d['name'].'"'.$dfielstr.'><option value="" keyid="">请选择'.$d['fieldlabel'].'</option></select>';
				$vstr .= '<select name="'.$d['name'].'__data" class="gradesearchfieldata">'.$options.'</select>';
			}
			$vstr .= '<input type="hidden" name="'.$d['name'].'_key" />';
		}
		return $vstr;
	}
}
?>