<?php

$data = false;
$events = false;

$inputs = Input::get('role', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'role.name' => 'required',
  'role.permissions' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'role.name:required' => 'Name is required',
  'role.permissions:required' => 'Permissions is required',
  'change_log.comment:required' => 'Reason for Change is required',
];

$errors = Input::validate($rules, $messages);
if ($errors) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => $errors[0],
    ],
  ];
  goto RESPONSE;
}

$name = $inputs['name'] ?? null;
$permissions = $inputs['permissions'] ?? [];

$role = Role::find($id);
$checkRole = Role::where('name', $name);

if (!$role) {
  $checkRole = $checkRole->first();
  if ($checkRole) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A role is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $role = new Role;
  $role->created_at = date('Y-m-d H:i:s');
} else {
  $checkRole = $checkRole->where('id', '!=', $role->id)->first();
  if ($checkRole) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A role is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$role->name = $name;
$role->permissions = $permissions;
$role->updated_at = date('Y-m-d H:i:s');
$role->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-role-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Role successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
