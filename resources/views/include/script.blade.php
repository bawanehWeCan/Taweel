<script src="{{ asset('all.js') }}"></script>
<!-- Stack array for including inline js or scripts -->
@stack('script')

<script>
$( "#dark" ).on('click',function() {
  $( 'body' ).toggleClass('dark');

  $a = 'light';

  if( $('body').hasClass('dark') ){
      $a='dark';
  }

  $.ajax({
   url: 'http://ta2weel.com/public/switch/'+$a,
   
});

});
</script>

<script src="{{ asset('dist/js/theme.js') }}"></script>
<script src="{{ asset('js/chat.js') }}"></script>

<script>
// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBE7yueBG7xfLD6BIjQITGcsdcT2V-aD2s",
  authDomain: "ta2weel-64d9f.firebaseapp.com",
  projectId: "ta2weel-64d9f",
  storageBucket: "ta2weel-64d9f.appspot.com",
  messagingSenderId: "994074818557",
  appId: "1:994074818557:web:6a312c36e39101b5328b94",
  measurementId: "G-1ME38SK45E"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
//firebase.analytics();
const messaging = firebase.messaging();
	messaging
.requestPermission()
.then(function () {
//MsgElem.innerHTML = "Notification permission granted." 
	console.log("Notification permission granted.");

     // get the token in the form of promise
	return messaging.getToken()
})
.then(function(token) {
 // print the token on the HTML page     
  console.log(token);
  
  
  
})
.catch(function (err) {
	console.log("Unable to get permission to notify.", err);
});

messaging.onMessage(function(payload) {
    console.log(payload.notification);
    var notify;
    notify = new Notification(payload.notification.title,{
        body: payload.notification.body,
        icon: payload.notification.icon,
        tag: "Dummy"
    });
    //console.log(payload.notification);
    alert(payload.notification.body);
});

    //firebase.initializeApp(config);
var database = firebase.database().ref().child("/users/");
   
database.on('value', function(snapshot) {
    renderUI(snapshot.val());
});

// On child added to db
database.on('child_added', function(data) {
	console.log("Comming");
    if(Notification.permission!=='default'){
        var notify;
         
        notify= new Notification('CodeWife - '+data.val().username,{
            'body': data.val().message,
            'icon': 'bell.png',
            'tag': data.getKey()
        });
        notify.onclick = function(){
            alert(this.tag);
        }
    }else{
        alert('Please allow the notification first');
    }
});

self.addEventListener('notificationclick', function(event) {       
    event.notification.close();
});




</script>