// import { initializeApp } from "firebase/app";

import { getFirestore, doc } from "firebase/firestore";

const firebaseConfig = {
    apiKey: "AIzaSyC5WiCc1kAt1RwMxkkGDLBdqvHqVJ9ei_4",
    authDomain: "wesushi-mizzup.firebaseapp.com",
    databaseURL: "https://wesushi-mizzup-default-rtdb.firebaseio.com",
    projectId: "wesushi-mizzup",
    storageBucket: "wesushi-mizzup.appspot.com",
    messagingSenderId: "30632354305",
    appId: "1:30632354305:web:eb38459ac55e94699b1600",
    measurementId: "G-FQLBRCWS0V",
};

// // Initialize Firebase
// const app = initializeApp(firebaseConfig);
// const analytics = getAnalytics(app);

// Initialize Cloud Firestore and get a reference to the service
const firestore = getFirestore();
const myDocRef = doc(firestore, "userscq", "1");
// async function readASingleDocument() {
//     const myDocRef = doc(firestore, "userscq", "1");
// }
