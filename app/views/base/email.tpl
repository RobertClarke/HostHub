<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>{{ title }}</title>
</head>
<body style="-webkit-text-size-adjust: 100%; background-color: #f7f7f7; font-family: Helvetica, Arial, sans-serif; font-size: 13px; text-align: center; margin: 0; padding: 10px;" bgcolor="#f7f7f7">
	<table style="border-collapse: collapse; table-layout: fixed; display: inline-block; margin: 0 auto;">
		<tr>
			<td style="padding: 20px; background-color: #fff; text-align: left; width: 500px;" align="left" bgcolor="#fff">
				{% block body %}{% endblock %}
			</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 500px; font-size: 11px; background-color: #f7f7f7; padding: 15px 10px 0;" align="center" bgcolor="#f7f7f7">
				{% block footer %}{% endblock %}
			</td>
		</tr>
	</table>
</body>
</html>
