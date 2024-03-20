<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Password Email</title>
    </head>
    <body style="background: #f9f9f9; padding: 0; margin:0; margin-bottom: 60px;">
        <div class="container">
            <header style="background: #000; padding-top: 50px; padding-bottom:80px; text-align: center;">
                <img src="{{asset('public/img/logo-dark.png')}}" alt="Kvitel logo" style="max-width: 300px; margin: auto !important; ">
            </header>
            <!-- Header box closed -->

            <div style="max-width: 1000px; margin: auto; margin-top: -40px; border: 1px solid #f3f3f3; border-bottom: 10px solid #566676; box-shadow:0px 2px 10px 0px rgba(0, 0, 0, 0.08); padding: 20px 20px; background: #fff;">
                <!--<h4 style="text-align: center; font-size: 30px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; color: rgba(0,0,0,70%);">Oops!</h4>-->

                <center><img src="{{asset('public/img/forgot.png')}}" alt="forgot icon" style="max-width: 120px; width: 100%; position: relative; left: 50%; transform: translateX(-41%); padding: 0px; "></center>

                <h4 style="text-align: center; font-size: 30px; font-family: 'open-sans',sans-serif; font-weight: 600; text-transform: capitalize; color: rgba(0,0,0,70%); margin-bottom: 25px;">Hello Dear {{$userName}},</h4>
                <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,50%); line-height: 1.7;">You received this e-mail because you have requested a new password in the Kvitel app. </p>
                <div style="text-align: center; margin: 40px 0px;"><a href="{{route('reset_password',$password_token)}}" style="padding: 10px 30px; background: #1abc9c; color: #fff; text-decoration: none; text-transform: capitalize; font-size: 14px; font-family: 'open-sans', sans-serif; letter-spacing: .5px; border-radius: 4px; box-shadow: 0px 2px 6px 0px rgba(0,0,0,26%);">Change Password</a></div>

                <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,50%); line-height: 1.7;">If you received this mail by mistake, please disregard this message.
                </p>
                <p style="  text-align: center; font-size: 40px; font-family: 'open-sans',cursive; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: 30px auto; color: rgba(0,0,0,50%); line-height: 1.7;"><strong>Thank You!</strong>
                </p>
                <hr style="border: 1px dashed #c5c5c5; margin-bottom: 30px;" />
                <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 400; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,50%); line-height: 1.7;">Regards,
                </p>
                <p style="  text-align: center; font-size: 20px; font-family: 'open-sans',sans-serif; font-weight: 600; text-transform: capitalize; max-width: 640px; width: 100%; margin: auto; color: rgba(0,0,0,70%); line-height: 1.7;">Kvitel Team
                </p>

            </div>
            <!-- Content box closed -->
        </div>

    </body>
</html>
