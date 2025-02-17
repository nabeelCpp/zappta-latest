window.fbAsyncInit = function() {
    FB.init({
      appId      : '573323387834188',
      cookie     : true,                     // Enable cookies to allow the server to access the session.
      xfbml      : true,                     // Parse social plugins on this webpage.
      version    : 'v14.0'           // Use this Graph API version for this call.
    });


    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
      statusChangeCallback(response);        // Returns the login status.
    });
};

FB.login(function(response) {
  // handle the response
}, {scope: 'public_profile,email'});

function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      FB.api('/me', function(response) {
        console.log('Successful login for: ' + JSON.stringify(response));
        
      });  
    } else {                                 // Not logged into your webpage or we are unable to tell.
      
    }
  }


function checkLoginState() {               // Called when a person is finished with the Login Button.
  FB.getLoginStatus(function(response) {   // See the onlogin handler
    statusChangeCallback(response);
  });
}