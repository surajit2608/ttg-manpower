<?php

Session::destroy('admin_id');
Response::redirect(ADMIN_URL . '/login', false);
