<?php

$data = false;
$events = false;

$rules = [
  'heart_bp' => 'required',
  'asthma_bronchitis_shortness_breath' => 'required',
  'diabetes' => 'required',
  'epilepsy_fainting_attacks' => 'required',
  'migraine' => 'required',
  'severe_head_injury' => 'required',
  'back_problems' => 'required',
  'allergies' => 'required',
  'nut_allergy' => 'required',
  'heart_circulatory_diseases' => 'required',
  'stomach_intestinal_disorders' => 'required',
  'difficulty_sleeping' => 'required',
  'fractures_ligament_damage' => 'required',
  'physical_other_disability' => 'required',
  'psychiatric_mental_illness' => 'required',
  'hospitalised_last_2years' => 'required',
  'suffered_carrier_infectious_diseases' => 'required',
  'registered_disabled' => 'required',
  'tuberculosis' => 'required',
  'skin_trouble_dermatitis' => 'required',
  'indigestive_stomach_trouble' => 'required',
  'chronic_chest_disorders' => 'required',
  'strict_time_medication' => 'required',
  'night_unfitness' => 'required',
  'health_details' => 'required',
  'medication_details' => 'required',
  'disclosure' => 'accepted',
];

$messages = [
  'heart_bp:required' => 'Heart trouble and/or blood presure problem is required',
  'asthma_bronchitis_shortness_breath:required' => 'Asthma, Bronchitis and/or shortness of breath is required',
  'diabetes:required' => 'Diabetes is required',
  'epilepsy_fainting_attacks:required' => 'Epilepsy and/or fainting attacks is required',
  'migraine:required' => 'Migraine is required',
  'severe_head_injury:required' => 'Severe Head Injury is required',
  'back_problems:required' => 'Back Problems is required',
  'allergies:required' => 'Allergies is required',
  'nut_allergy:required' => 'Nut Allergy is required',
  'heart_circulatory_diseases:required' => 'Heart or circulatory diseases is required',
  'stomach_intestinal_disorders:required' => 'Stomach or intestinal disorders is required',
  'difficulty_sleeping:required' => 'Any condition which causes difficulty sleeping is required',
  'fractures_ligament_damage:required' => 'Fractures, Tendon, Ligament/Cartilage damage is required',
  'physical_other_disability:required' => 'Physical or other disability is required',
  'psychiatric_mental_illness:required' => 'Psychiatric or Mental Illness is required',
  'hospitalised_last_2years:required' => 'Have you been hospitalised within the last 2 years is required',
  'suffered_carrier_infectious_diseases:required' => 'Are you suffering from or a carrier of any infectious diseases is required',
  'registered_disabled:required' => 'Are you registered as disabled is required',
  'tuberculosis:required' => 'Have you ever had or have tuberculosis is required',
  'skin_trouble_dermatitis:required' => 'Have you ever had or have skin trouble or dermatitis is required',
  'indigestive_stomach_trouble:required' => 'Have you ever suffered or suffer from recurring indigestive, stomach or bowel trouble is required',
  'chronic_chest_disorders:required' => 'Chronic chest disorders (especially if night time symptoms are troublesome) is required',
  'strict_time_medication:required' => 'Any medical condition which requires medication to a strict time table is required',
  'night_unfitness:required' => 'Other health issues which may affect your fitness at night is required',
  'health_details:required' => 'If you have answered yes to any of the above questions, please give further details below is required',
  'medication_details:required' => 'Do you currently use any form of medication regularly? If so, please give details below is required',
  'disclosure:accepted' => 'Please check the terms & conditions',
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

$inputs = Input::all();

$id = $inputs['id'] ?? 0;

$inputs['updated_at'] = date('Y-m-d H:i:s');
if (!$id) {
  $inputs['created_at'] = date('Y-m-d H:i:s');
  $id = WorkerHealth::insertGetId($inputs);
} else {
  WorkerHealth::where('id', $id)->update($inputs);
}

$health = WorkerHealth::find($id);

$data = [
  'health' => $health,
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Occupational Health Section successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
