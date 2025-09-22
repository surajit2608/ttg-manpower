<?php

Session::destroy('user_id');
Response::redirect(SITE_URL . '/', false);
