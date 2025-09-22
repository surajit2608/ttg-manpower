<?php

if (Session::get('user_id')) {
  Response::redirect('/dashboard', false);
} else {
  Response::redirect('/login', false);
}
