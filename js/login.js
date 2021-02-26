let u = _("username");
let p = _("password");
let bl = _("btn-login");
let lf = _("login-form");
let lfe = _("login-error");
u.style.textTransform = "lowercase";
lf.addEventListener("submit", function (event) {
  event.preventDefault();
  if (clean(u) && clean(p)) {
    // SEND TO LOGIN QUERY
    $.ajax({
      url: "./control/action.php",
      data: {
        login: "login",
        u: u.value,
        p: p.value,
      },
      method: "POST",
      beforeSend: function () {
        bl.disabled = true;
        bl.innerHTML = `${loadIcon} Logging`;
        lfe.innerHTML = "";
      },
      success: function (data) {
        if (
          data.trim() === "<div class='text-success'>LOGIN SUCCESSFULLY</div>"
        ) {
          lfe.innerHTML = data;
          window.location = "./dashboard/";
        } else {
          lfe.innerHTML = data;
          bl.innerHTML = `Login`;
          bl.disabled = false;
        }
      },
    });
  } else {
    lfe.innerHTML = "ALL FIELDS REQUIRED";
  }
});
