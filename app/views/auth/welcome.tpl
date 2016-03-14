{% extends 'base/page.tpl' %}

{% set title = 'Welcome!' %}

{% set body_id = 'welcome' %}
{% set body_class = 'boxed' %}

{% block body %}
<aside id="side">
	<div class="container">
		<div class="top">
			<div id="logo">Host List</div>
		</div>
		<div class="middle">
			<div class="text">
				<h2>Welcome{% if username is not empty %} {{ username }}{% endif %}!</h2>
				<h3>Your account was created</h3>
			</div>
		</div>
		<div class="bottom">
			<p>Ready to sign in?</p>
			<a href="/register" class="button blue">Sign into my account</a>
		</div>
	</div>
</aside>
<section id="main">
	<h1>Welcome to Host List!</h1>
</section>
{% endblock %}
