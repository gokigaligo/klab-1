
// start payment script
function cashpay() {
    event.preventDefault();
    var phone = $("#clientphone").val();
    var name = $("#clientname").val();
    var mode = $("#mode").val();
    if(phone == ''){
       window.alert("please fill phone field");
       return false;
    }
    else if (name == '') {
    	window.alert("please fill Name field");
       	return false;
    }
    else if (mode == 'pickup') {
		document.getElementById('cash').style.display = 'block';
		document.getElementById('mtn').style.display = 'none';
		document.getElementById('visa').style.display = 'none';
		document.getElementById('tigo').style.display = 'none';
		document.getElementById('paying').style.display = 'none';
		document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('paymentwithdelivery').style.display = 'none';
		document.getElementById('paymentwithoutdelivery').style.display = 'block';
		document.getElementById('clientlocation').style.display = 'none';
		document.getElementById('emailmemberinfo').style.display = 'none';
		document.getElementById('confirmnonmember').style.display = 'none';
		document.getElementById('confirmmember').style.display = 'none';
    }
    else if (mode == '' || mode == 'select mode') {
    	window.alert("please select mode of paying and taking order. ");
       	return false;
    }
    else{
		document.getElementById('cash').style.display = 'block';
		document.getElementById('mtn').style.display = 'none';
		document.getElementById('visa').style.display = 'none';
		document.getElementById('tigo').style.display = 'none';
		document.getElementById('paying').style.display = 'none';
		document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('paymentwithoutdelivery').style.display = 'none';
		document.getElementById('paymentwithdelivery').style.display = 'block';
		document.getElementById('clientlocation').style.display = 'block';
		document.getElementById('emailmemberinfo').style.display = 'none';
		document.getElementById('confirmnonmember').style.display = 'none';
		document.getElementById('confirmmember').style.display = 'none';
	}
}
function tigopay() {
    event.preventDefault();
    var phone = $("#clientphone").val();
    var name = $("#clientname").val();
    var mode = $("#mode").val();
    if(phone == ''){
       window.alert("please fill phone field");
       return false;
    }
    else if (name == '') {
    	window.alert("please fill Name field");
       	return false;
    }
    else if (mode == '' || mode == 'select mode') {
        window.alert("please select mode of paying and taking order. ");
        return false;
    }
    else if (mode == 'pickup') {
        document.getElementById('tigo').style.display = 'block';
        document.getElementById('mtn').style.display = 'none';
        document.getElementById('visa').style.display = 'none';
        document.getElementById('cash').style.display = 'none';
        document.getElementById('paying').style.display = 'none';
        document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('tigodelivery').style.display = 'none';
        document.getElementById('tigowithoutdelivery').style.display = 'block';
    }
    else{
		document.getElementById('tigo').style.display = 'block';
		document.getElementById('mtn').style.display = 'none';
		document.getElementById('visa').style.display = 'none';
		document.getElementById('cash').style.display = 'none';
		document.getElementById('paying').style.display = 'none';
		document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('tigodelivery').style.display = 'block';
        document.getElementById('tigowithoutdelivery').style.display = 'none';
	}
}
function mtnpay() {
    event.preventDefault();
    var phone = $("#clientphone").val();
    var name = $("#clientname").val();
    var mode = $("#mode").val();
    if(phone == ''){
       window.alert("please fill phone field");
       return false;
    }
    else if (name == '') {
    	window.alert("please fill Name field");
       	return false;
    }
    else if (mode == '' || mode == 'select mode') {
        window.alert("please select mode of paying and taking order. ");
        return false;
    }
    else if (mode == 'pickup') {
        document.getElementById('mtn').style.display = 'block';
        document.getElementById('tigo').style.display = 'none';
        document.getElementById('visa').style.display = 'none';
        document.getElementById('cash').style.display = 'none';
        document.getElementById('paying').style.display = 'none';
        document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('mtnclientlocation').style.display = 'none';
        document.getElementById('mtndelivery').style.display = 'none';
        document.getElementById('mtnwithoutdelivery').style.display = 'block';
    }
    else{
		document.getElementById('mtn').style.display = 'block';
		document.getElementById('tigo').style.display = 'none';
		document.getElementById('visa').style.display = 'none';
		document.getElementById('cash').style.display = 'none';
		document.getElementById('paying').style.display = 'none';
		document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('mtnclientlocation').style.display = 'block';
        document.getElementById('mtnwithoutdelivery').style.display = 'none';
        document.getElementById('mtndelivery').style.display = 'block';
	}
}
function visapay() {
    event.preventDefault();
    var phone = $("#clientphone").val();
    var name = $("#clientname").val();
    var mode = $("#mode").val();
    if(phone == ''){
       window.alert("please fill phone field");
       return false;
    }
    else if (name == '') {
    	window.alert("please fill Name field");
       	return false;
    }
    else if (mode == '' || mode == 'select mode') {
        window.alert("please select mode of paying and taking order. ");
        return false;
    }
    else if (mode == 'pickup') {
        document.getElementById('visa').style.display = 'block';
        document.getElementById('mtn').style.display = 'none';
        document.getElementById('tigo').style.display = 'none';
        document.getElementById('cash').style.display = 'none';
        document.getElementById('paying').style.display = 'none';
        document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('visadelivery').style.display = 'none';
        document.getElementById('visawithoutdelivery').style.display = 'block';
    }
    else{
		document.getElementById('visa').style.display = 'block';
		document.getElementById('mtn').style.display = 'none';
		document.getElementById('tigo').style.display = 'none';
		document.getElementById('cash').style.display = 'none';
		document.getElementById('paying').style.display = 'none';
		document.getElementById('clientinfofill').style.display = 'none';
        document.getElementById('visadelivery').style.display = 'block';
        document.getElementById('visawithoutdelivery').style.display = 'none';
	}
}
function back() {
	document.getElementById('visa').style.display = 'none';
	document.getElementById('mtn').style.display = 'none';
	document.getElementById('tigo').style.display = 'none';
	document.getElementById('cash').style.display = 'none';
	document.getElementById('paying').style.display = 'block';
	document.getElementById('clientinfofill').style.display = 'block';
}
function member() {
    var floorname = $("#floor_name").val();
    var officename = $("#clientoffice").val();
    var mode = $("#mode").val();

    if (mode == 'delivery' && (floorname == '' || floorname == 'select floor')) {
        window.alert("please select floor where you found");
        return false;
    }
    else if (mode == 'delivery' && officename == '') {
    	alert("Please enter an office where you found");
    	return false;
    }
    else {
		document.getElementById('emailmemberinfo').style.display = 'inline';
		document.getElementById('clientlocation').style.display = 'none';
		document.getElementById('confirmnonmember').style.display = 'none';
	}
}
function showmember() {
	document.getElementById('confirmmember').style.display = 'block';
	document.getElementById('confirmnonmember').style.display = 'none';
}
function nonmember() {
    var floorname = $("#floor_name").val();
    var officename = $("#clientoffice").val();
    var mode = $("#mode").val();

    if (mode == 'delivery' && (floorname == '' || floorname == 'select floor')) {
        window.alert("please select floor where you found");
        return false;
    }
    else if (mode == 'delivery' && officename == '') {
    	alert("Please enter an office where you found");
    	return false;
    }
    else {
		document.getElementById('emailmemberinfo').style.display = 'none';
		document.getElementById('confirmnonmember').style.display = 'block';
		document.getElementById('confirmmember').style.display = 'none';
	}
}