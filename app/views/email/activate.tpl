{% extends 'base/email.tpl' %}

{% block body %}
	<p style="font-weight: bold; color: #3e4751; font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 2em; margin-top: 0; margin-bottom: 5px;">Hi {{ username|default('there') }},</p>
	<p style="font-family: Helvetica, Arial, sans-serif; font-size: 13px; color: #7c7e7f; line-height: 2em; margin-top: 0; margin-bottom: 5px;">Before you can use your Host List account we need to confirm your email address. Click the button below to confirm your email and we'll activate your account:</p>
	<p style="font-family: Helvetica, Arial, sans-serif; font-size: 13px; color: #7c7e7f; line-height: 2em; margin-top: 0; margin-bottom: 0; text-align: center;" align="center"><a href="{{ url|default('#') }}" style="width: 160px; display: inline-block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; text-align: center; font-size: 14px; background-color: #64C520; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; margin-bottom: 15px; margin-top: 10px; padding: 12px 16px;">Confirm Email Address</a></p>
	<p style="font-family: Helvetica, Arial, sans-serif; font-size: 13px; color: #7c7e7f; line-height: 2em; margin-top: 0; margin-bottom: 0;">Cheers,<br />The Host List Team</p>
{% endblock %}

{% block footer %}
	<p style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #7c7e7f; line-height: 2em; margin-top: 0; margin-bottom: 8px;">Problems clicking the button? Use this link: <a href="{{ url|default('#') }}" style="color: #7c7e7f; text-decoration: underline;">{{ url|default('#') }}</a></p>
	<p style="font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #7c7e7f; line-height: 2em; margin-top: 0; margin-bottom: 0;">If you didn't register this account, ignore this email.</p>
{% endblock %}
