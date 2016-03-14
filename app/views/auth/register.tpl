{% extends 'base/page.tpl' %}

{% set title = 'Sign Up' %}

{% set body_id = 'register' %}
{% set body_class = 'boxed' %}

{% block body %}
<aside id="side">
	<div class="container">
		<div class="top">
			<div id="logo">Host List</div>
		</div>
		<div class="middle">
			<div class="text">
				<h2>Join the community</h2>
				<h3>Creating an account is free</h3>
				<ul>
					<li><i class="icon-check"></i> Join community discussions</li>
					<li><i class="icon-check"></i> Post your hosting offers</li>
					<li><i class="icon-check"></i> Save offers for later</li>
				</ul>
			</div>
		</div>
		<div class="bottom">
			<p>Already have an account?</p>
			<a href="/login" class="button blue">Sign into my account</a>
		</div>
	</div>
</aside>
<section id="main">
	<h1>Sign up for a new account</h1>
	<form action="/register" method="POST">
{% if error is defined and error is not empty %}
		<div class="message {{ errorType|default('error') }}">
			<ul>{% for e in error %}<li>{{ e }}</li>{% endfor %}</ul>
		</div>
{% endif %}
		<div class="input with-icon">
			<i class="icon-face"></i>
			<input type="text" name="username" id="username" placeholder="Username" value="{{ username|escape }}">
		</div>
		<div class="input with-icon">
			<i class="icon-mail"></i>
			<input type="text" name="email" id="email" placeholder="Email" value="{{ email|escape }}">
		</div>
		<div class="input with-icon">
			<i class="icon-key"></i>
			<input type="password" name="password" id="password" placeholder="Password">
		</div>
		<div class="extras">
			<div class="check centered">
				<input type="checkbox" name="agree" id="agree" value="1"{% if agree is not empty %} checked="checked"{% endif %}>
				<label for="agree">I agree to the <a href="/terms">terms and conditions</a></label>
			</div>
		</div>
		<div class="submit">
			<button type="submit" name="submit" id="submit" class="button green"><span>Create Account</span><div class="loader"></div></button>
		</div>
	</form>
</section>
{% endblock %}
