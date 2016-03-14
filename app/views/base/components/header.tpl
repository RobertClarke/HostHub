<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{% if title is defined %}{{ title }} | {% endif %}Host List</title>
	<link rel="stylesheet" href="/assets/css/main.css" type="text/css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" type="text/css">

	<link rel="stylesheet" href="https://i.icomoon.io/public/temp/51f1566b94/HostList/style.css">

	<link rel="shortcut icon" href="/favicon.ico">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta name="format-detection" content="telephone=no">
</head>
<body{% if body_id is defined %} id="{{ body_id }}"{% endif %}{% if body_class is defined %} class="{{ body_class }}"{% endif %}>
{% if body_class !=  'boxed' %}{% block header %}
	<section id="header">
		<div class="wrapper">
			<div id="logo">Host List</div>
		</div>
	</section>
{% endblock %}{% endif %}
{% if subheader is not empty %}
	{% include 'base/components/subheader.tpl' with {subheader: subheader} %}
{% endif %}
<section id="content">
	<div class="wrapper">
