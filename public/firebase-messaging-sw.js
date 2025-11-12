// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    apiKey: "AIzaSyAMKiGSXPznxQJiQnjrRMF305msH8HsG5o",
    authDomain: "habl--ghaseel.firebaseapp.com",
    projectId: "habl--ghaseel",
    storageBucket: "habl--ghaseel.appspot.com",
    messagingSenderId: "90205887384",
    appId: "1:90205887384:web:bcef94e07ea9aea6e3e9ed",
    measurementId: "G-Q2WNXJZ8P6"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("background");
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});
