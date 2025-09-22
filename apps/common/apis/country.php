<?php

$data = false;
$events = false;

$id = Input::get('id', null);
$search = Input::get('q', null);

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);

$countries = Country::where(function($query) use(&$search){
  if($search){
    $query->where('value', 'like', '%'.$search.'%');
    $query->orWhere('label', 'like', '%'.$search.'%');
  }
});

if($id){
  $countries->where('value', $id);
}

if($page != -1){
  $countries->limit($limit)->skip($skip);
}

$countries = $countries->get();

foreach($countries as $country){
  $data[] = [
    'value' => $country->value,
    'label' => $country->label,
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
