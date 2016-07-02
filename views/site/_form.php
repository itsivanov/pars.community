<section>
	<div class="row">
		<div class="form-box col-md-8 col-md-offset-2">
			<form method="POST" action="/">
				<div class="text-center">
					<div class="title">Emails</div>
				</div>
				<div class="form-group">
					<label for="email-input">Email</label>
					<input type="email" class="form-control" name="email-input" id="email-input" value="" placeholder="email" />
				</div>
				<div class="form-group">
					<label for="email-text">Email text</label>
					<input type="email" class="form-control" name="email-text" id="email-text" value="" placeholder="email text" />
				</div>

				<div class="row">
					<div class="col-md-8">
						<div id="error-block" class="error-block">

						</div>
					</div>
					<div class="col-md-4 text-right">
						<div onclick="formSender.send(); return false;" class="btn btn-primary">Send</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>