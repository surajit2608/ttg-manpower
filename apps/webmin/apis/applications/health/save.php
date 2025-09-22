<?php

$data = false;
$events = false;

$rules = [
  'health.heart_bp' => 'required',
  'health.asthma_bronchitis_shortness_breath' => 'required',
  'health.diabetes' => 'required',
  'health.epilepsy_fainting_attacks' => 'required',
  'health.migraine' => 'required',
  'health.severe_head_injury' => 'required',
  'health.back_problems' => 'required',
  'health.allergies' => 'required',
  'health.nut_allergy' => 'required',
  'health.heart_circulatory_diseases' => 'required',
  'health.stomach_intestinal_disorders' => 'required',
  'health.difficulty_sleeping' => 'required',
  'health.fractures_ligament_damage' => 'required',
  'health.physical_other_disability' => 'required',
  'health.psychiatric_mental_illness' => 'required',
  'health.hospitalised_last_2years' => 'required',
  'health.suffered_carrier_infectious_diseases' => 'required',
  'health.registered_disabled' => 'required',
  'health.tuberculosis' => 'required',
  'health.skin_trouble_dermatitis' => 'required',
  'health.indigestive_stomach_trouble' => 'required',
  'health.chronic_chest_disorders' => 'required',
  'health.strict_time_medication' => 'required',
  'health.night_unfitness' => 'required',
  'health.health_details' => 'required',
  'health.medication_details' => 'required',
  'health.disclosure' => 'accepted',
  'change_log.comment' => 'required',
];

$messages = [
  'health.heart_bp:required' => 'Heart trouble and/or blood presure problem is required',
  'health.asthma_bronchitis_shortness_breath:required' => 'Asthma, Bronchitis and/or shortness of breath is required',
  'health.diabetes:required' => 'Diabetes is required',
  'health.epilepsy_fainting_attacks:required' => 'Epilepsy and/or fainting attacks is required',
  'health.migraine:required' => 'Migraine is required',
  'health.severe_head_injury:required' => 'Severe Head Injury is required',
  'health.back_problems:required' => 'Back Problems is required',
  'health.allergies:required' => 'Allergies is required',
  'health.nut_allergy:required' => 'Nut Allergy is required',
  'health.heart_circulatory_diseases:required' => 'Heart or circulatory diseases is required',
  'health.stomach_intestinal_disorders:required' => 'Stomach or intestinal disorders is required',
  'health.difficulty_sleeping:required' => 'Any condition which causes difficulty sleeping is required',
  'health.fractures_ligament_damage:required' => 'Fractures, Tendon, Ligament/Cartilage damage is required',
  'health.physical_other_disability:required' => 'Physical or other disability is required',
  'health.psychiatric_mental_illness:required' => 'Psychiatric or Mental Illness is required',
  'health.hospitalised_last_2years:required' => 'Have you been hospitalised within the last 2 years is required',
  'health.suffered_carrier_infectious_diseases:required' => 'Are you suffering from or a carrier of any infectious diseases is required',
  'health.registered_disabled:required' => 'Are you registered as disabled is required',
  'health.tuberculosis:required' => 'Have you ever had or have tuberculosis is required',
  'health.skin_trouble_dermatitis:required' => 'Have you ever had or have skin trouble or dermatitis is required',
  'health.indigestive_stomach_trouble:required' => 'Have you ever suffered or suffer from recurring indigestive, stomach or bowel trouble is required',
  'health.chronic_chest_disorders:required' => 'Chronic chest disorders (especially if night time symptoms are troublesome) is required',
  'health.strict_time_medication:required' => 'Any medical condition which requires medication to a strict time table is required',
  'health.night_unfitness:required' => 'Other health issues which may affect your fitness at night is required',
  'health.health_details:required' => 'If you have answered yes to any of the above questions, please give further details below is required',
  'health.medication_details:required' => 'Do you currently use any form of medication regularly? If so, please give details below is required',
  'health.disclosure:accepted' => 'Please check the terms & conditions',
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

$inputs = Input::get('health', []);

$id = $inputs['id'] ?? 0;

$inputs['updated_at'] = date('Y-m-d H:i:s');
if (!$id) {
  $inputs['created_at'] = date('Y-m-d H:i:s');
  $id = WorkerHealth::insertGetId($inputs);
} else {
  WorkerHealth::where('id', $id)->update($inputs);
}

$health = WorkerHealth::find($id);


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'health' => $health,
  'change_log.comment' => '',
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
