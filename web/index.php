<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>AjentiMailAdmin</title>
		<link rel="stylesheet" href="//cdn.jsdelivr.net/g/bootstrap@3.3.6(css/bootstrap.min.css),sweetalert@1.1.3(sweetalert.css)"/>
		<link rel="stylesheet" href="index.css"/>
	</head>
	<body>
		<div data-bind="visible:!authenticated()" class="loginwindow">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title" data-bind="text:Translation.get('logintext')"></h3>
				</div>
				<div class="panel-body">
					<form data-bind="submit:_login" class="form-group">
						<input class="form-control" data-bind="attr: { placeholder:Translation.get('email') }, textInput: email">
						<input class="form-control" data-bind="attr: { placeholder:Translation.get('password') }, textInput: password" type="password">
						<input data-bind="value:Translation.get('login')" type="submit" class="btn btn-success form-control">
					</form>
				</div>
			</div>

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title" data-bind="text:Translation.get('passwordforgotten')"></h3>
				</div>
				<div class="panel-body">
					<form data-bind="submit:_passwordForgotten" class="form-group">
						<input class="form-control" data-bind="attr: { placeholder:Translation.get('email') }, textInput: passwordemail">
						<input class="form-control btn-info" data-bind="value:Translation.get('sendpassword')" type="submit">
					</form>
				</div>
			</div>
		</div>

		<div data-bind="visible:authenticated()" class="appwindow">
			<h2><span data-bind="text:Translation.get('headline')"></span><span data-bind="text:email()"></span></h2>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title" data-bind="text:Translation.get('forwarders')"></h3>
				</div>
				<div class="panel-body">
					<div data-bind="visible:forwardersEnabled()">
						<table class="table table-striped form-group">
							<tbody data-bind="foreach:forwarders()">
								<tr>
									<td data-bind="text:$data"></td>
									<td>
										<button class="form-control btn btn-warning" data-bind="click:$parent._deleteForwarder, text:Translation.get('delete')"></button>
									</td>
								</tr>
							</tbody>
						</table>
						<form data-bind="submit:_addForwarder" class="form-group">
							<table class="table table-striped">
								<tbody>
									<tr>
										<td><input class="form-control" data-bind="value:newforwarder, attr: {placeholder:Translation.get('addnewforwarder')}"></td>
										<td>
											<input class="form-control btn btn-success" data-bind="value:Translation.get('save')" type="submit">
										</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
					<p data-bind="visible:!forwardersEnabled(), text:Translation.get('forwardersdisabled')"></p>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title" data-bind="text:Translation.get('changepassword')"></h3>
				</div>
				<div class="panel-body">
					<form data-bind="submit:_changePassword" class="form-group">
						<input class="form-control" type="password" data-bind="attr: { placeholder:Translation.get('newpass1') }, value:newpass1">
						<input class="form-control" type="password" data-bind="attr: { placeholder:Translation.get('newpass2') }, value:newpass2">
						<input class="form-control btn btn-info" data-bind="value:Translation.get('save')" type="submit">
					</form>
				</div>
			</div>

			<div class="panel panel-default" data-bind="visible:features.fail2ban_enabled()">
				<div class="panel-heading">
					<h3 class="panel-title" data-bind="text:Translation.get('accountlocked')"></h3>
				</div>
				<div class="panel-body">
					<form data-bind="submit:_unblockUser" class="form-group">
						<p data-bind="text:Translation.get('accountlockexplanation')"></p>
						<input class="form-control btn btn-link" data-bind="value:Translation.get('unlockmyaccount')" type="submit">
					</form>
				</div>
			</div>

			<button class="btn btn-danger" data-bind="click:_logout, text:Translation.get('logout')"></button>
		</div>

		<div data-bind="visible:loading()" class="loadingwindow">
			<div class="inner">
				<br>
				<div class="preloader"></div>
				<br>
				<p data-bind="text:Translation.get('apploading')"></p>
			</div>
		</div>

		<script src="//cdn.jsdelivr.net/g/jquery@2.2.2,knockout@3.4.0,js-cookie@2.2.0,spinjs@2.3.2,sweetalert@1.1.3,js-md5@0.4.1"></script>
		<script src="translations.js"></script>
		<script src="config.js"></script>
		<script src="index.js"></script>
	</body>
</html>