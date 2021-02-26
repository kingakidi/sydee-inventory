let u = _('username');
let fn = _('fullname');
let e = _('email');
let p = _('phone');
let g = _('gender');
let password = _('password');
let aCode = _('activation');
let bs = _('btn-signup');
let sf = _('signup-form');
let sfe = _('signup-error')
fn.style.textTransform = "capitalize";
u.style.textTransform = "lowercase";
// ERRORS 
let ee = _('email-error');

// ON KEYUP FOR USERNAME AND EMAIL ADDRESS 
u.addEventListener('keyup', function () {
    if (u.value.trim() !== "") {
        if (!isNaN(u.value.charAt(0))) {
            _('username-error').innerHTML = "Username can't start with number";
        }else if(clean(u) < 5){
            _('username-error').innerHTML = "Minimum of 5 Character";
        }else{
            // SEND TO CHECK IF EXIST IN DB 
            _('username-error').innerHTML = "";
        }
    }else{
        _('username-error').innerHTML = "";
    }
    
   
    
})

// ON BLUR FOR USERNAME 
u.addEventListener('blur', function () {
    if (clean(u) > 0) {
        if (!isNaN(u.value.charAt(0))) {
            _('username-error').innerHTML = "Username can't start with number";
        }else if(clean(u) < 5){
            _('username-error').innerHTML = "Minimum of 5 Character";
        }else{
            // SEND TO CHECK IF EXIST IN DB 
            _('username-error').innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            $.ajax({
                url: './control/action.php',
                method: 'POST',
                data: {
                    u: u.value,
                    checkUsername: 'checkUsername',

                }, 
                beforeSend: function () {
                    _('username-error').innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                },
                success: function(data){
                    _('username-error').innerHTML = data

                }
            })
        }
    }else{
        _('username-error').innerHTML = "";
    }
})

e.addEventListener('blur', function () {

    if (e.value.trim() !== "") {
     
      if (!eV(e.value)) {
        ee.innerHTML = "Invalid Email Address";  
      }else{
        ee.innerHTML = "";  
      }
    }else{
        ee.innerHTML = "";
    }
})


sf.addEventListener('submit', function (event) {
    event.preventDefault();

    if (clean(u) < 1 || clean(fn) < 1 || clean(e) < 1 || clean(p) < 1 || clean(g) < 1 || clean(password) < 1 || clean(aCode) < 1) {
        sfe.innerHTML = "ALL FIELDS REQUIRED";
    }else{
        sfe.innerHTML = "";
        // SEND IT 
        $.ajax({
            url: './control/action.php',
            method: 'POST', 
            data: {
                signup: 'signup', 
                u: u.value, 
                e: e.value, 
                fn: fn.value, 
                p: p.value, 
                g: g.value, 
                password: password.value, 
                acode: aCode.value
            }, 
            beforeSend: function () {
                bs.innerHTML = `${loadIcon} Loading`;
                bs.disabled = true;
            }, 

            success: function (data) {
                if (data.trim() === "<span class='text-success'>Registered Successfully</span>") {
                    window.location = 'http://localhost/esphem/login.php?register=successfully';
                }else{
                    sfe.innerHTML =  data;
                    bs.disabled = false
                    bs.innerHTML = "Signup";
                   
                }
              
            }
        })
    }
})