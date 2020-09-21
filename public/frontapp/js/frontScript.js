// code by Chris. cherubin / 2ch-design.com / feb 2014 /sib
//================================== VACHES =====================================

function cin() {
    var e = document.getElementById("create_eleveur_cin");
    if(e)
    {
    e.oncopy = function (e) {
        e.preventDefault()
    };
    e.onpaste = function (e) {
        e.preventDefault()
    }
    }
}

function cin2() {
    var f = document.getElementById("create_eleveur_cin2");
    if(f)
    {
    f.oncopy = function (f) {
        f.preventDefault()
    };
    f.onpaste = function (f) {
        f.preventDefault()
    }
    }
}

function tag() {
    var e = document.getElementById("create_animal_tag");
	var et = document.getElementById("tag");
    if(e) {
	e.oncopy = function (e) {
        e.preventDefault()
    };
	
    e.onpaste = function (e) {
        e.preventDefault()
    };
	}
    if(et) {
	et.oncopy = function (et) {
        et.preventDefault()
    };
    et.onpaste = function (et) {
        et.preventDefault()
    }
}
}

function tag2() {
    var a = document.getElementById("tag");
if(a)
{
    a.oncopy = function (b) {
        b.preventDefault()
    };
    a.onpaste = function (b) {
        b.preventDefault()
    }
}
}


function enregVache() {
   
    var n = document.getElementById("create_animal_tag");
    var r = document.getElementById("tag");
    var i = document.getElementById("create_animal_carnet");
    var s = document.getElementById("carnet");
    if (n.value == "" || r.value == "" || i.value == "" || s.value == "") {
        alert("Oups!!! #TAG ak #KANÈ yo vid.");
        return false
    } else if (n.value != r.value || i.value != s.value) {
        alert("Oups!!! #TAG ak #KANÈ dwe menm.");
        return false
    } else {
        return true
    }
}


//==================================AGENTS=====================================

function enregAgent() {
   
    var n = document.getElementById("create_agent_cin");
    var r = document.getElementById("cin2");
    var i = document.getElementById("create_agent_so");
    var s = document.getElementById("so2");
    if (n.value == "" || r.value == "" || i.value == "" || s.value == "") {
        alert("Oups!!! #SO ak #CIN yo vid.");
        return false
    } else if (n.value != r.value || i.value != s.value) {
        alert("Oups!!! #SO ak #CIN dwe menm bagay");
        return false
    } else {
        return true
    }
}

//===================== ELEVEURS =============================

function enregElveur() {
    
    var n = document.getElementById("create_eleveur_cin");
    var r = document.getElementById("create_eleveur_cin2");
    if (n.value == "" || r.value == "") {
        alert("Tout chan ki gen asteris rouj yo obligatwa.");
        return false
    } else if ( r.value != n.value ) {
        alert("Oups! CIN yo dwe menm.");
        return false
    } else {
        return true
    }
}

//======================= USERS =====================================

function inscr() {
	
	//var err='';
	
    var f = document.getElementById("create_user_fName");
    var l = document.getElementById("create_user_lName");
    var p = document.getElementById("create_user_phone");
	
    var e = document.getElementById("create_user_email");	
    var w = document.getElementById("create_user_password");
    var r = document.getElementById("create_user_repeat_password");
    var c = document.getElementById("captcha");
	

    if (f.value == "" || l.value == "" || p.value == "" || e.value == "" || w.value == ""  || r.value == ""  || c.value == "" ) {
        alert('Tout chan yo obligatwa.');
        return false
    } else if (w.value != r.value) {
        alert('Modpas yo dwe menm.');
        return false
    } else {
        return true
    }
		
	
}


function cnt(){
	
    var u = document.getElementById("username");
    var p = document.getElementById("password");
	
    if (u.value == "" || p.value == "") {
        return false
    } else {
        return true
    }
	
	
}



window.onload = function () {
    
  
    cin();
    cin2();
	
	//cinAg();
	//cinAg2();
	
	tag();
	tag2();
	
    //so();
	//cinEl();
	//cinEl1();
  //  so2()
}