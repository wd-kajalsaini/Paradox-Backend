<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password Email Template</title>
</head>
<body style="background: #f9f9f9; padding: 0; margin:0; margin-bottom: 60px;">
    <div class="container">
        <header style="background: #000; padding-top: 20px; padding-bottom:50px; text-align: center;">
            <img src="{{asset('img/logo-dark.png')}}" alt="company logo" style="max-width: 300px; margin: auto !important; ">
        </header>
        <div style="max-width: 1000px; margin: auto; margin-top: -40px; border: 1px solid #f3f3f3; border-bottom: 10px solid #566676; box-shadow:0px 2px 10px 0px rgba(0, 0, 0, 0.08); padding: 20px 20px; background: #fff;">
            <h4 style="text-align: center; font-size: 30px; font-family: 'open-sans',sans-serif; font-weight: 600; text-transform: capitalize; color: rgba(0,0,0,70%); margin-bottom: 25px;">Hello {{ $userName }},</h4>
            <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,50%); line-height: 1.7;">You received this e-mail because you have requested a new password in the Paradox. </p>
            <div style="text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,50%); line-height: 1.7;">OTP : {{ $password_token }}</div>
            <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,50%); line-height: 1.7;">If you received this mail by mistake, please disregard this message.
            </p>
            <p style="  text-align: center; font-size: 40px; font-family: 'open-sans',cursive; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: 30px auto; color: rgba(0,0,0,50%); line-height: 1.7;"><strong>Thank You!</strong>
            </p>
            <hr style="border: 1px dashed #c5c5c5; margin-bottom: 30px;" />
            <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,50%); line-height: 1.7;">Regards,
            </p>
            <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 600; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,70%); line-height: 1.7;">Paradox Team
            </p>
        </div>
    </div>
</body>
</html>
