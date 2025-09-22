<?php

$data = false;
$events = false;

$id = Input::get('id', null);
$search = Input::get('q', null);

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);

$timezones = Tmzone::where(function($query) use(&$search){
  if($search){
    $query->where('value', 'like', '%'.$search.'%');
    $query->orWhere('label', 'like', '%'.$search.'%');
  }
});

if($id){
  $timezones->where('value', $id);
}

if($page != -1){
  $timezones->limit($limit)->skip($skip);
}

$timezones = $timezones->get();

foreach($timezones as $timezone){
  $data[] = [
    'value' => $timezone->value,
    'label' => $timezone->label,
    'details' => $timezone->details,
  ];
}

RESPONSE:
if(!$data){
  $data = [];
}
return [
  'data' => $data,
  'events' => $events,
];
