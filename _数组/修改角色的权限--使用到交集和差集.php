<?php
public function updateRole($data)
{
    $rule = array(
        'role_id' => ['required', 'int'],
        'role_name' => ['required'],
        'permission_ids' => ['required', 'array'],
        'is_system' => ['required', 'in:0,1'],
    );
    $validator = Validator::make($data, $rule);
    if ($validator->fails()) {
        throw new JsonException(10000, $validator->messages());
    }

    //获取角色详情
    $detail_role = $this->getRoleDetails($data['role_id']);

    //当前角色权限集合
    $cur_permission = $detail_role->permission_list->toArray();
    $cur_permission = array_column($cur_permission,'permission_id');
    unset($detail_role->permission_list);

    //角色名
    if (isset($data['role_name']) && !empty($data['role_name'])) {
        $detail_role->role_name = $data['role_name'];
    }
    //是否系统内置
    if (isset($data['is_system'])) {
        $detail_role->is_system = $data['is_system'];
    }
    $detail_role->last_edit_time = time();
    $detail_role->save();

    /***********************这里开始是重点**************************/
    $old = $cur_permission;//角色现有的权限ID集合
    $new = $data['permission_ids'];//重新选择后要修改的权限ID集合

    //需要删除的权限
    $del_permission_arr = array_diff($old, $new);

    //需要全新增加的权限
    $add_permission_arr = array_diff($new, $old);

    //删除老权限
    if(count($del_permission_arr)>0){

        $affected = App::make('RelationRolePermissionsModel')->whereIn('permission_id', $del_permission_arr)->delete();
        if (!$affected) {
            throw new JsonException(40208);
        }
    }

    //增加新权限
    if(count($add_permission_arr)>0){
        $insert_data = [];
        foreach ($add_permission_arr as $k=>$permission_id){
            $insert_data[$k]['permission_id'] = $permission_id;
            $insert_data[$k]['role_id'] = $detail_role->id;
            $insert_data[$k]['created_at'] = Helper::getNow();
            $insert_data[$k]['updated_at'] = Helper::getNow();
        }
        $insert_obj = App::make('RelationRolePermissionsModel')->insert($insert_data);
        if (!$insert_obj) {
            throw new JsonException(40101);
        }
    }

    return $detail_role;

}