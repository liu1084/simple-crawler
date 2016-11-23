<?php
/**
 * Created by IntelliJ IDEA.
 * User: jim
 * Date: 2016/11/22
 * Time: 14:03
 */
require_once("All.php");

$all = new All();
$path = "D:\download\allitebooks.com\www.allitebooks.com";

$htmls = $all->readHtml($path);
foreach($htmls as $i => $html){
    echo '(' . $i . ')' . $html . '<br/>';
    try{
        $all->processHtml($html);
    }catch (Exception $e){
        print_r("<p style='color: #f00; font-weight: 600;'>Exception:" .$e->getMessage() . '</p><br/>');
        continue;
    }
}