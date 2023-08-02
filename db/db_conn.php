<?php

require __DIR__ . '/../../../db.php';
ORM::configure("mysql:host=$hostname;dbname=$db_name");
ORM::configure('username', $username);
ORM::configure('password', $password);
ORM::get_db();