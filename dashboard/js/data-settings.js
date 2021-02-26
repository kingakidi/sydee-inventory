let pLink = document.getElementsByName("p-link");
let show = _("show-item");
let loadIcon = '<i class="fa fa-spinner fa-spin"></i>';
let popupShow = _("popup-page");
let sPContent = _("show-popup-content");
let pClose = _("popup-close");

pLink.forEach(function (element) {
  let id = element.id;
  element.addEventListener("click", function (event) {
    event.preventDefault();
    show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
    if (id.trim().toLowerCase() === "creditors") {
      // SEND FOR SALES FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          creditors: "creditors",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let addCreditor = _("add-creditor");
        let viewCreditor = _("view-creditor");
        let formContainer = _("creditor-form-container");
        addCreditor.onclick = function () {
          // SEND AJAX FOR CREDITOR FORM
          $.ajax({
            url: "./control/forms.php",
            method: "POST",
            data: {
              creditorForm: "creditorForm",
            },
            beforeSend: function () {
              formContainer.innerHTML = loadIcon;
            },
            success: function (data) {
              formContainer.innerHTML = data;
            },
          }).done(function () {
            // DECLARE VARIABLES
            let creditorForm = _("creditor-form");
            let name = _("name");
            let email = _("email");
            let phone = _("phone");
            let gender = _("gender");
            let organization = _("organization");
            let address = _("address");
            let cFError = _("creditor-form-error");
            let btnCreditor = _("btn-creditor");

            creditorForm.onsubmit = function (event) {
              event.preventDefault();
              // check for all fields filled
              if (
                clean(name) > 0 &&
                clean(email) > 0 &&
                clean(phone) > 0 &&
                clean(gender) > 0 &&
                clean(organization) > 0 &&
                clean(address) > 0
              ) {
                // CHECK FOR CORRECT PHONE NUMBER
                if (clean(phone) !== 11) {
                  cFError.style.visibility = "visible";
                  cFError.innerHTML = error("INVALID PHONE NUMBER");
                } else {
                  // SEND REQUEST
                  $.ajax({
                    url: "./control/action.php",
                    method: "POST",
                    data: {
                      addCreditorForm: "addCreditorForm",
                      name: name.value,
                      email: email.value,
                      phone: phone.value,
                      gender: gender.value,
                      organization: organization.value,
                      address: address.value,
                    },
                    beforeSend: function () {
                      cFError.style.visibility = "visible";
                      cFError.innerHTML = loadIcon;
                      btnCreditor.disabled = true;
                      btnCreditor.innerHTML = `${loadIcon} Adding`;
                    },

                    success: function (data) {
                      btnCreditor.disabled = false;
                      btnCreditor.innerHTML = "Submit";
                      cFError.innerHTML = data;
                      cFError.style.visibility = "visible";
                    },
                  });
                }
              } else {
                cFError.style.visibility = "visible";
                cFError.innerHTML = error("ALL FIELD(S) REQUIRED");
              }
            };
          });
        };
        viewCreditor.onclick = function () {
          formContainer.innerHTML = loadIcon;
          $.ajax({
            url: "./control/action.php",
            method: "POST",
            data: {
              getCreditors: "getCreditors",
            },
            beforeSend: function () {
              formContainer.innerHTML = loadIcon;
            },
            success: function (data) {
              formContainer.innerHTML = data;
            },
          });
        };
      });
    } else if (id.trim().toLowerCase() === "programs") {
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          programs: "programs",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // DECLARE ALL THE VARIABLES
        let pFContainer = _("program-form-container");
        let viewProgam = _("view-program");
        let addProgram = _("add-program");
        addProgram.onclick = function () {
          // SEND FOR ADD PROGRAM FORM
          $.ajax({
            url: "./control/forms.php",
            method: "POST",
            data: {
              addProgramForm: "addProgramForm",
            },
            beforeSend: function () {
              pFContainer.innerHTML = loadIcon;
            },
            success: function (data) {
              pFContainer.innerHTML = data;
            },
          }).done(function () {
            let programForm = _("program-form");
            let name = _("program-name");
            let duration = _("duration");
            let fees = _("fees");
            let pFError = _("program-form-error");
            let btnPF = _("btn-program");
            programForm.onsubmit = function (event) {
              event.preventDefault();
              if (clean(name) > 0 && clean(duration) > 0 && clean(fees) > 0) {
                // SEND AJAX
                $.ajax({
                  url: "./control/action.php",
                  method: "POST",
                  data: {
                    submitProgramForm: "submitProgramForm",
                    name: name.value,
                    duration: duration.value,
                    fees: fees.value,
                  },
                  beforeSend: function () {
                    pFError.innerHTML = loadIcon;
                    pFError.style.visibility = "visible";
                    btnPF.disabled = true;
                    btnPF.innerHTML = `${loadIcon} Adding`;
                  },
                  success: function (data) {
                    if (
                      data.trim() ===
                      "<div class='text-success'>PROGRAM ADDED SUCCESSFULLY</div>"
                    ) {
                      pFError.innerHTML = data;
                      pFError.style.visibility = "visible";
                      btnPF.disabled = true;
                      btnPF.innerHTML = "Submit";
                      programForm.reset();
                    } else {
                      pFError.innerHTML = data;
                      pFError.style.visibility = "visible";
                      btnPF.disabled = false;
                      btnPF.innerHTML = "Submit";
                      console.log(data);
                    }
                  },
                });
              } else {
                pFError.style.visibility = "visible";
                pFError.innerHTML =
                  "<span class='text-danger'> All fields required </span>";
              }
            };
          });
        };
        viewProgam.onclick = function () {
          pFContainer.innerHTML = loadIcon;
          $.ajax({
            url: "./control/action.php",
            method: "POST",
            data: {
              getPrograms: "getPrograms",
            },
            beforeSend: function () {
              pFContainer.innerHTML = loadIcon;
            },
            success: function (data) {
              pFContainer.innerHTML = data;
            },
          });
        };
      });
    } else if (id.trim().toLowerCase() === "payments") {
      show.innerHTML = show.innerHTML =
        '<i class="fa fa-spinner fa-spin fa-3x"></i>';
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          payments: "payments",
        },
        beforeSend: function () {
          show.innerHTML = loadIcon;
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let addPayment = _("add-payment");
        let viewPayment = _("view-payment");
        let paymentFormContainer = _("payment-form-container");
        addPayment.onclick = function () {
          // SEND FOR ADD PAYMENT FORM
          $.ajax({
            url: "./control/forms.php",
            method: "POST",
            data: {
              paymentTypeForm: "paymentTypeForm",
            },
            beforeSend: function () {
              paymentFormContainer.innerHTML = loadIcon;
            },
            success: function (data) {
              paymentFormContainer.innerHTML = data;
            },
          }).done(function () {
            // DECLARE
            let paymentForm = _("payments-form");
            let typeName = _("type-name");
            let accountNumber = _("account-number");
            let pFError = _("payment-form-error");
            let btnPayment = _("btn-payment");

            paymentForm.onsubmit = function (event) {
              event.preventDefault();
              if (clean(typeName) > 0) {
                $.ajax({
                  url: "./control/action.php",
                  method: "POST",
                  data: {
                    submitPaymentForm: "submitPaymentForm",
                    typeName: typeName.value,
                    accountNumber: accountNumber.value,
                  },
                  beforeSend: function () {
                    pFError.innerHTML = loadIcon;
                    pFError.style.visibility = "visible";
                    btnPayment.disabled = true;
                    btnPayment.innerHTML = `${loadIcon} Adding`;
                  },
                  success: function (data) {
                    if (
                      data.trim() ===
                      "<div class='text-success'>PAYMENT TYPE ADDED SUCCESSFULLY</div>"
                    ) {
                      pFError.innerHTML = data;
                      pFError.style.visibility = "visible";
                      btnPayment.disabled = true;
                      btnPayment.innerHTML = "Submit";
                    } else {
                      pFError.innerHTML = data;
                      pFError.style.visibility = "visible";
                      btnPayment.disabled = false;
                      btnPayment.innerHTML = "Submit";
                    }
                  },
                });
              } else {
                pFError.innerHTML = error("All fields required");
                pFError.style.visibility = "visible";
              }
            };
          });
        };

        viewPayment.onclick = function () {
          paymentFormContainer.innerHTML = loadIcon;

          // REQUEST FOR LIST
          $.ajax({
            url: "./control/action.php",
            method: "POST",
            data: {
              getPaymentList: "getPaymentList",
            },
            beforeSend: function () {
              paymentFormContainer.innerHTML = loadIcon;
            },
            success: function (data) {
              paymentFormContainer.innerHTML = data;
            },
          });
        };
      });
    }
  });
});

// LINKS USING CLASS
pLinkClass = document.getElementsByClassName("item-link");
for (let index = 0; index < pLinkClass.length; index++) {
  const element = pLinkClass[index];
  element.onclick = function () {
    let id = element.id;
    _(id).style.backgroundColor = "#fff";

    let notLink = document.querySelectorAll(`.item-link:not(#${id})`);
    notLink.forEach(function (el) {
      let id = el.id;
      _(id).style.backgroundColor = "#eee";
    });
  };
}

// END OF LINKS USING CLASS
