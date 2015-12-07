 var xmlHttp = new XMLHttpRequest();   

function process(){
    // Create our XMLHttpRequest object
    var url = "processBooking.php";
    var customerName = document.getElementById("customerName").value;
    var contactNum = document.getElementById("contactNum").value;
    var uniNum = document.getElementById("unitNum").value;
    var streetNum = document.getElementById("streetNum").value;
    var streetName = document.getElementById("streetName").value;
    var suburb = document.getElementById("suburb").value;
    var deAddress = document.getElementById("deAddress").value;
    var deSuburb = document.getElementById("deSuburb").value;
    var date = document.getElementById("date").value;
    var time = document.getElementById("time").value;
    var pass = document.getElementById("pass").value;
    var referenceNum = reference();
    var vars = "&customerName="+customerName+"&contactNum="+contactNum + "&uniNum=" + uniNum + "&streetNum=" + streetNum + "&streetName=" + streetName
                +"&suburb=" + suburb + "&deAddress=" + deAddress + "&deSuburb=" + deSuburb + "&date=" + date + "&time=" + time + "&pass=" + pass + "&referenceNum=" + encodeURIComponent(referenceNum); 
    xmlHttp.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    xmlHttp.onreadystatechange = function() {
	    if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		    var return_data = xmlHttp.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    
    xmlHttp.send(vars); 
}
//get reference for each booking
function reference(){
    var streetNum = document.getElementById("streetNum").value;
    var contactNum = document.getElementById("contactNum").value;
    var ref = streetNum+contactNum;
    return ref;
}
