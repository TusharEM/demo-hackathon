<?php
$request_body = file_get_contents('php://input');
print "<pre>";
print_r($request_body)
