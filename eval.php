<?php

header('Content-Type: application/json');        


echo json_encode(file_get_contents("./lua.lua"));