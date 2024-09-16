<?php

session_start();

session_destroy();

header("Location: ../signup-login/signup.html");

exit;