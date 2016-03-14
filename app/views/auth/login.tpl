{% extends 'base/page.tpl' %}

{% set title = 'Sign In' %}

{% set body_id = 'login' %}
{% set body_class = 'boxed' %}

{% block body %}
<aside id="side">
	<div class="container">
		<div class="top">
			<div id="logo">Host List</div>
		</div>
		<div class="middle">
			<div class="text">
				<h2>Welcome back!</h2>
				<h3>Please sign in to continue</h3>
			</div>
		</div>
		<div class="bottom">
			<p>Don't have an account?</p>
			<a href="/register" class="button green">Create an account</a>
		</div>
	</div>
</aside>
<section id="main">
	<h1>Sign into your account</h1>
	<form action="/login" method="POST">
{% if error is defined and error is not empty %}
		<div class="message {{ errorType|default('error') }}">{{ error|raw }}</div>
{% endif %}
		<div class="input with-icon">
			<i class="icon-face"></i>
			<input type="text" name="username" id="username" placeholder="Username or email" value="{{ username|escape }}">
		</div>
		<div class="input with-icon">
			<i class="icon-key"></i>
			<input type="password" name="password" id="password" placeholder="Password">
		</div>
		<div class="extras">
			<div class="check">
				<input type="checkbox" name="remember" id="remember" value="1"{% if remember is not empty %} checked="checked"{% endif %}>
				<label for="remember">Stay signed in</label>
			</div>
			<div class="right">
				<a href="/forgot">Forgot password?</a>
			</div>
		</div>
		<div class="submit">
			<button type="submit" name="submit" id="submit" class="button blue"><span>Sign In</span><div class="loader"></div></button>
		</div>
	</form>
</section>
{% endblock %}
