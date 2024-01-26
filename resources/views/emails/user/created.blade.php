<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="color-scheme" content="only" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Card Curator OTP Confirmation Email</title>

	</head>

	<body>
		<table
				cellpadding="0"
				cellspacing="0"
				border="0"
				id="backgroundTable"
				bgcolor="#002333"
		>
			<tr>
				<td style="background-color: #002333" colspan="3" bgcolor="#002333">
					<img
							class="top-banner"
							style="width: 100%"
							src="https://www.cardcurator.com/hubfs/CardCurator/images/email_files/Top-Banner.png"
							alt="Email Header"
					/>
				</td>
			</tr>
			<tr>
				<td height="25"></td>
			</tr>
			<tr>
				<td colspan="3" style="font-family: Questrial, Arial, Helvetica, sans-serif; align-self: center; width: 800px; color: #ffffff;">
					<h1 style="color: #ffffff; text-align: center;">
						Hi <span style="color: #8fd91c">{{ $user->name }}</span>
					</h1>
					<p style="color: #ffffff; text-align: center;">
						<br />Welcome to the Card Curator admin portal.<br />
						Here you can view all the downloads from your unique referral
						link.<br />
						<br />
						You will be required to update the password on first login.<br /><br />
						Username: {{ $user->email }}<br/>
						Password: {{ $password }}<br/><br />
						<a href="http://bfs.test/">Login Admin Portal</a
						><br /><br />
						{{-- https://admin.creditcardcurator.com/--}}
						Kind regards<br />
						Card Curator Team
					</p>
				</td>
			</tr>
			<tr>
				<td height="25"></td>
			</tr>
			<tr>
				<td style="background-color: #002333" colspan="3" bgcolor="#002333">
					<table style="width: 100%">
						<tr>
							<td style="width: 358px">
								<img
										src="https://www.cardcurator.com/hubfs/CardCurator/images/email_files/Footer-Image.png"
										style="height: 70%"
										alt="Email Footer"
								/>
							</td>
							<td></td>
							<td style="text-align: right; width: 213px" width="213">
								<table width="100%">
									<tr>
										<td width="40">
											<a href="https://www.instagram.com/card_curator/"
											><img
														alt="Instagram"
														src="https://www.cardcurator.com/hubfs/CardCurator/images/email_files/CCC_Instagram.png"
														style="
                            width: 40px;
                            padding-top: 10px;
                            padding-right: 20px;
                          "
														width="40"
												/></a>
										</td>
										<td width="40">
											<a href="https://www.facebook.com/CardCurator"
											><img
														alt="Facebook"
														src="https://www.cardcurator.com/hubfs/CardCurator/images/email_files/CCC_Facebook.png"
														style="
                            width: 40px;
                            padding-top: 10px;
                            padding-right: 20px;
                          "
														width="40"
												/></a>
										</td>
										<td width="40">
											<a href="https://www.linkedin.com/company/cardcurator/"
											><img
														alt="LinkedIn"
														src="https://www.cardcurator.com/hubfs/CardCurator/images/email_files/CCC_LinkedIn.png"
														style="
                            width: 40px;
                            padding-top: 10px;
                            padding-right: 20px;
                          "
														width="40"
												/></a>
										</td>
										<td width="40">
											<a href="https://twitter.com/Card_Curator"
											><img
														alt="Twitter"
														src="https://www.cardcurator.com/hubfs/CardCurator/images/email_files/CCC_Twitter.png"
														style="
                            width: 40px;
                            padding-top: 10px;
                            padding-right: 20px;
                          "
														width="40"
												/></a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
