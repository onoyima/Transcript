
 function makePayment() {

var merchantId = "8434377560";
var apiKey = "154279"
var serviceTypeId = "8422574399"
var d = new Date();
var orderId = d.getTime();
var totalAmount = "10000";

var apiHash = CryptoJS.SHA512(merchantId+ serviceTypeId+ orderId+totalAmount+apiKey);

            // WARNING: For POST requests, body is set to null by browsers.
var data = {
"serviceTypeId": merchantId,
"amount": totalAmount,
"orderId": orderId,
"payerName": "Infiniti System Enterprises",
"payerEmail": "dapo.apara@infinitisys.comg",
"payerPhone": "08023391777",
"description": "ACCPTANCE"
    //"expiryDate": "05/09/2021"
}

var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function() {
if(this.readyState === 4) {
  console.log(this.responseText);
}
});

xhr.open("POST", "login.remita.net");
xhr.setRequestHeader("Content-Type", "application/json");
xhr.setRequestHeader("Authorization", "remitaConsumerKey=2547916,remitaConsumerToken=aebcd563f37f2a5c3a3b20c4c4ba27dbc09231f00bcd39fc6dd2753de52193968ada688860761d28f8d951b82b5c35d7992d8d23cde68aacfd677a6a857fa187");

xhr.send(data);
    }
