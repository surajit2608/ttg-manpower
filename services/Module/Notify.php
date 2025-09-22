<?php

namespace Module;

use User;
use Email;
use Session;
use Notification;

class Notify
{
  function toAdmin($moduleOrUser, $contents, $url = null)
  {
    $contents = (object)$contents;
    $subject = $contents->subject;
    $emailBody = $contents->email ?? null;
    $notificationBody = $contents->notification ?? null;

    $emails = [];
    $notifications = [];
    $senderId = Session::get('user_id', 0);
    $users = User::whereNull('deleted_at');
    if (!is_string($moduleOrUser)) {
      $users->where('id', $moduleOrUser->id);
    }
    $users = $users->get();
    foreach ($users as $user) {
      if (is_string($moduleOrUser)) {
        $permission = $user->permission[$moduleOrUser . '_module']->value ?? null;
      } else {
        $permission = 'Allow';
      }

      if ($permission == 'Allow') {
        $emails[] = $user->email;
        if (!$notificationBody) {
          continue;
        }

        $notifications[] = [
          'url' => $url,
          'status' => 'unread',
          'sender_id' => $senderId,
          'receiver_id' => $user->id,
          'receiver_type' => 'admin',
          'content' => $notificationBody,
          'updated_at' => date('Y-m-d H:i:s'),
          'created_at' => date('Y-m-d H:i:s'),
        ];
      }
    }
    if (count($notifications)) {
      Notification::insert($notifications);
    }
    if ($emailBody) {
      $this->email($emails, $subject, $emailBody);
    }
  }

  function toWorker($worker, $contents, $url = null)
  {
    $contents = (object)$contents;
    $subject = $contents->subject;
    $emailBody = $contents->email ?? null;
    $notificationBody = $contents->notification ?? null;

    if ($notificationBody) {
      $senderId = Session::get('admin_id', 0);
      Notification::insert([
        'url' => $url,
        'status' => 'unread',
        'sender_id' => $senderId,
        'receiver_type' => 'worker',
        'receiver_id' => $worker->id,
        'content' => $notificationBody,
        'updated_at' => date('Y-m-d H:i:s'),
        'created_at' => date('Y-m-d H:i:s'),
      ]);
    }
    if ($emailBody) {
      $this->email($worker->email, $subject, $emailBody);
    }
  }

  function email($to, $subject, $message)
  {
    return Email::send($to, $subject, $message);
  }
}
