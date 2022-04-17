<?php

$public = isset($_POST['public']) ? $_POST['public'] : null;
$private = isset($_POST['private']) ? $_POST['private'] : null;
$encoded = isset($_POST['encoded']) ? $_POST['encoded'] : null;

function str2bin($text){
	$bin = array();
	for($i=0; strlen($text)>$i; $i++)
		$bin[] = decbin(ord($text[$i]));
	return implode(' ', $bin);
}
function wrap($string) {
	return "\xEF\xBB\xBF".$string."\xEF\xBB\xBF"; // Unicode Character 'ZERO WIDTH NON-BREAKING SPACE' (U+FEFF) 0xEF 0xBB 0xBF
}

function unwrap($string) {
	$tmp = explode("\xEF\xBB\xBF", $string);
	if(count($tmp) == 1) return false; // If the string doesn't contain the boundary, return false
	return $tmp[1]; // Otherwise, return the unwrapped string
}

function bin2str($bin){
	$text = array();
	$bin = explode(' ', $bin);
	for($i=0; count($bin)>$i; $i++)
		$text[] = chr(@bindec($bin[$i]));
	return implode($text);
}

function bin2hidden($str) {
	$str = str_replace(' ', "\xE2\x81\xA0", $str); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
	$str = str_replace('0', "\xE2\x80\x8B", $str); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
	$str = str_replace('1', "\xE2\x80\x8C", $str); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80 0x8C
	return $str;
}

function hidden2bin($str) {
	$str = str_replace("\xE2\x81\xA0", ' ', $str); // Unicode Character 'WORD JOINER' (U+2060) 0xE2 0x81 0xA0
	$str = str_replace("\xE2\x80\x8B", '0', $str); // Unicode Character 'ZERO WIDTH SPACE' (U+200B) 0xE2 0x80 0x8B
	$str = str_replace("\xE2\x80\x8C", '1', $str); // Unicode Character 'ZERO WIDTH NON-JOINER' (U+200C) 0xE2 0x80
	return $str;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<style>
@import url('https://rsms.me/inter/inter.css');
html { font-family: 'Inter', sans-serif; }
@supports (font-variation-settings: normal) {
	html { font-family: 'Inter var', sans-serif; }
}
body {
	margin: 5em 4em;
	background-color: lightgrey;
}
