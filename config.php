<?php


$host       = "ec2-46-137-84-140.eu-west-1.compute.amazonaws.com";
$username   = "sztcaemwhnjarb";
$password   = "5ef2453f05878c2bc03bed8fc8019d40045186511c980af5c89c59d4e177bf5c";
$dbname     = "d7nutckef01oqb";
$dsn        = "pgsql:host=$host;dbname=$dbname";
$options    = array(
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);