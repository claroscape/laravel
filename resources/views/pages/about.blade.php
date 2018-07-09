<head>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/0.9.0/fetch.js"></script>
<script src="/application_domain.js"></script>
<script>
// This is the code obtained from the Janrain dashboard.
(function() {
  if (typeof window.janrain !== 'object') window.janrain = {};
  if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
  // This is where you can add/modify Janrain Widget settings.
  janrain.settings.tokenUrl = 'http://localhost:3000';
  janrain.settings.tokenAction = 'event';
  janrain.settings.type = 'modal';
  janrain.settings.linkClass = 'social-login-button';
  // Only edit above this line.
  function isReady() { janrain.ready = true; };
  if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", isReady, false);
  } else {
    window.attachEvent('onload', isReady);
  }
  var e = document.createElement('script');
  e.type = 'text/javascript';
  e.id = 'janrainAuthWidget';
  if (document.location.protocol === 'https:') {
    e.src = 'https://rpxnow.com/js/lib/' + appName + '/engage.js';
  } else {
    e.src = 'http://widget-cdn.rpxnow.com/js/lib/' + appName + '/engage.js';
  }
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(e, s);
}());
</script>
</head>
<body>
  <!-- Notice the class on this link is the same as what we configured in
  janrain.settings.linkClass? The widget automatically attaches a click handler
  to this link. -->
  <a href="javascript:void(0)" class="social-login-button">Sign In</a>
  <div id="messageContainer"></div>
  <code><pre id="profileContainer"></pre></code>
</body>
<script>
// This is the function that will welcome endusers to our site! For
// demonstration purposes, we'll also print out the full profile.
function welcomeUser(profile) {
  var messageContainer = document.getElementById('messageContainer');
  var profileContainer = document.getElementById('profileContainer');
  var name = profile.displayName;
  messageContainer.innerHTML = '<h2>Welcome, ' + name + '!</h2>';
  prettyPrintedProfile = JSON.stringify(profile, null, 2);
  profileContainer.innerHTML = prettyPrintedProfile;
}
// janrainWidgetOnLoad is a special function that gets called as soon as the the
// Janrain widget is loaded on the page. Attach all of your event handlers
// within this function.
function janrainWidgetOnload() {
  // This event fires once Janrain's Social Login service has responded with the
  // access token. We'll send this token to our token_url to retrieve the
  // profile.
  janrain.events.onProviderLoginToken.addHandler(function(response) {
    fetch('http://localhost:3000/profile?token=' + response.token)
      // First, get the response as JSON.
      .then(function(res) { return res.json(); })
      // Then, welcome the user to the site and log them in.
      .then(welcomeUser)
      // Finally, close the widget modal.
      .then(janrain.engage.signin.modal.close);
  });
}
</script>

