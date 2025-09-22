<?php

if (Session::get('admin_id')) {
  Response::redirect(ADMIN_URL . '/dashboard', false);
} else {
  Response::redirect(ADMIN_URL . '/login', false);
}
