<?php
!defined('IN_CMS') && exit('Access Denied');
template("index","","index_".md5(array_to_string($_GET,$separator="_")));