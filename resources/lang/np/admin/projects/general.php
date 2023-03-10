<?php

return [

    'audit-log'           => [
        'category'              => 'Projects',
        'msg-index'             => 'Accessed list of projects.',
        'msg-show'              => 'Accessed details of project: :name.',
        'msg-store'             => 'Created new project: :name.',
        'msg-edit'              => 'Initiated edit of project: :name.',
        'msg-update'            => 'Submitted edit of project: :name.',
        'msg-destroy'           => 'Deleted project: :name.',
        'msg-enable'            => 'Enabled project: :name.',
        'msg-disabled'          => 'Disabled project: :name.',
        'msg-enabled-selected'  => 'Enabled multiple projects.',
        'msg-disabled-selected' => 'Disabled multiple projects.',
    ],

    'status'              => [
        'created'                   => 'Project successfully created',
        'updated'                   => 'Project successfully updated',
        'deleted'                   => 'Project successfully deleted',
        'global-enabled'            => 'Selected projects enabled.',
        'global-disabled'           => 'Selected projects disabled.',
        'enabled'                   => 'Project enabled.',
        'disabled'                  => 'Project disabled.',
        'no-project-selected'          => 'No project selected.',
    ],

    'error'               => [
        'cant-delete-this-project' => 'This project cannot be deleted',
        'cant-edit-this-project'   => 'This project cannot be edited',
    ],

    'page'              => [
        'index'              => [
            'title'             => 'Admin | Projects',
            'description'       => 'List of projects',
            'table-title'       => 'Project list',
        ],
        'show'              => [
            'title'             => 'Admin | Project | Show',
            'description'       => 'Displaying project: :name',
            'section-title'     => 'Project details',
        ],
        'create'            => [
            'title'            => 'Admin | Project | Create',
            'description'      => 'Creating a new project',
            'section-title'    => 'New project',
        ],
        'edit'              => [
            'title'            => 'Admin | Project | Edit',
            'description'      => 'Editing project: :name',
            'section-title'    => 'Edit project',
        ],
    ],

    'columns'           => [
        'id'                        =>  'ID',
        'name'                      =>  '?????????',
        'assign_to'                 =>  '???????????????????????? ?????????????????????',
        'description'               =>  '???????????????',
        'start_date'                =>  '???????????? ????????????',
        'end_date'                  =>  '?????????????????? ????????????',
        'status'                    =>  '??????????????????',
        'actions'                   =>  '????????????????????????',
        'enabled'                   =>  '??????????????? ??????????????????',
        'resync_on_login'           =>  '?????????????????? ??????????????????y?????? ???????????????????????????',

        'user'=>'?????????????????????????????????',

        'subject'=>'????????????',
        'class'=>'???????????????',
        'manager'=>'????????????????????????',
        'staffs'=>'?????????????????????????????????',
        'category'=>'????????????',
        'tagline'=>'???????????????????????????',
        'summary'=>'??????????????????',
        'task'=>'???????????????',
        'due'=>'??????????????????',
        'priority'=>'??????????????????????????????',
        'owner'=>'???????????????',
        'stage'=>'????????????',

        'project'=>'???????????????????????????',
        'project_task'=>'??????????????????????????? ???????????????',
        'people'=>'???????????????????????????',
        'start_date'=>'???????????? ????????????',
        'end_date'=>'?????????????????? ????????????',
        'progress'=>'??????????????????',

        'title'=>'??????????????????',
        'select_project'=>'??????????????????????????? ???????????? ???????????????????????????',
        'description'=>'???????????????',
        'add_task'=>'????????? ???????????????????????????',

        'staffs_involved'=>'???????????????????????? ??????????????????',

        'estimated_duration'=>'???????????????????????? ????????????',
        'schedule'=>'??????????????????',
        'attachment'=>'?????????????????????',

        'estimated'=>'????????????????????????',
        'deadlines'=>'?????????????????????',

        'activity'=>'?????????????????????',
        'date'=>'????????????',

    ],

    'button'               => [
        'create_project'    =>  '???????????? ??????????????????????????? ????????????????????? ???????????????????????????',
        'quick_task'=>'??????????????? ???????????????',
        'edit_project'=>'???????????????????????? ????????????????????? ???????????????????????????',
        'create_task'=>'??????????????? ????????????????????? ???????????????????????????',
        'backlogs'=>'?????????????????????????????????',
        'activity'=>'?????????????????????',
        'filter'=>'???????????? ???????????????????????????',
        'reset'=>'??????????????? ???????????????????????????',
        'send'=>'??????????????????????????????',
        'save_close'=>'????????? ??????????????????????????? ??? ???????????? ???????????????????????????',
        'edit'=>'????????????????????? ???????????????????????????',
        'delete'=>'??????????????????',
    ],

    'placeholder'=>[
        'search_project'=>'??????????????????????????? ??????????????????????????????',
        'start_date'=>'???????????? ????????????',
        'end_date'=>'?????????????????? ????????????',
        'comment_post'=>'????????????????????? ???????????? ??????????????? ???????????????????????? ???????????????????????????',

    ],

    'titles'=>[

        'activity_logs' =>'??????????????? ????????????????????? ??????',
    ],

];
