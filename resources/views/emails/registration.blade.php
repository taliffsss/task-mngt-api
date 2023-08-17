<!DOCTYPE html>
<html>
   <head>
      <title>Email Verification</title>
   </head>
   <body>
      <!-- Begin page -->
      <div id="layout-wrapper" style="width: 100%; background-color: #f3f3f9; padding-bottom: 60px;">
         <div class="main-content" style="margin: 0 auto; max-width: 70%; font-family: Arial, Helvetica, sans-serif; color: #171a1b;">
            <div class="page-content">
               <!-- Container -->
               <div class="container-fluid" style="width: 100%; background-color: #ffffff; border: 1px solid #d7d7d7; border-radius: 10px; padding: 20px;">
                  <!-- Page title -->
                  <div class="wrapper" style="padding-bottom: 10px; position: relative;">
                     <div class="main" style="font-size: 15px;">
                        <img src="https://cdn.mywanderlinx.com/assets/images/WanderLinx_FINAL_1.png" alt="" style="width: 100px; float: right;">
                        <div style="font-size: 14px; font-weight: 600;">{{ $greet }}</div>
                     </div>
                  </div>
                  <!-- Registration details -->
                  <div style="padding: 20px 0;">
                     <div style="margin-bottom: 10px;">
                        <div style="font-size: 14px; font-weight: normal; color: #0f294d;">
                           Registered On: {{ $registerDate }}
                        </div>
                     </div>
                     <div style="font-size: 14px; font-weight: normal; color: #0f294d;">
                        <div>Email: <span>{{ $email }}</span></div>
                        <div>Password: <span style="font-weight: 600;">{{ $password }}</span></div>
                        <div>You can log in using the <a href="{{ $link }}" style="font-weight: 700; color: #2196F3; text-decoration: none;">Click Here!</a>.</div>
                        <br>
                        <div>
                           For your security, we recommend changing your password after your initial login. This step ensures the utmost safety for your account. Remember, it is essential not to share your login information with others to maintain the integrity of your account.
                        </div>
                     </div>
                  </div>
                  <!-- Help section -->
                  <div style="border: 1px solid #d7d7d7; border-radius: 10px; text-align: left; padding: 20px; background-color: #ffffff;">
                     <div class="main" style="font-size: 15px;">
                        <img src="https://cdn.mywanderlinx.com/assets/images/call-image.png" alt="" style="width: 60px; float: right;">
                        <div style="font-size: 18px; font-weight: 500; color: #0f294d; margin-bottom: 10px;">
                           Need Help? 
                        </div>
                     </div>
                     <div style="font-size: 14px; color: #455873; line-height: 24px; margin-bottom: 20px;">
                        Do you have any questions or concerns about your Account?
                     </div>
                     <div>
                        <a rel="noopener noreferrer" href="https://www.facebook.com/wanderlinx" style="font-size: 16px; font-weight: 500; color: #3264ff; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: 1px solid #3264ff;" target="_blank">Chat with Us</a>
                     </div>
                  </div>
                  <!-- Automated response -->
                  <div style="border: 1px solid #d7d7d7; margin-top: 20px; padding: 20px; border-radius: 10px; background-color: #FFFFFF;">
                     <div style="font-size: 14px; color: #0f294d;">
                        Please note that this is an automated response. Replies to this email address are not monitored. Thanks for your time, and we look forward to helping you with your next trip!
                     </div>
                  </div>
                  <!-- Footer -->
                  <div style="padding: 20px; background-color: #272f33; font-size: 12px; color: #ffffff; line-height: 20px; direction: ltr;" align="left">
                     Business Registered: Brgy. San Felipe Naga City, Naga City, Camarines Sur, Philippines 4401. Company Number: 09081905060; DTI Registration Number: 208148618
                  </div>
               </div>
               <!-- Container -->
            </div>
            <!-- End Page-content -->
         </div>
         <!-- End main content -->
      </div>
      <!-- END layout-wrapper -->
   </body>
</html>
