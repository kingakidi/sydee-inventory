let pLink = document.getElementsByName("p-link");
let show = _("show-item");
let loadIcon = '<i class="fa fa-spinner fa-spin"></i>';
let popupShow = _("popup-page");
let sPContent = _("show-popup-content");
let pClose = _("popup-close");
let forms = "./control/forms.php";
let action = "./control/action.php";
pClose.onclick = function () {
  popupShow.style.display = "none";
};
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
pLink.forEach(function (element) {
  let id = element.id;

  element.addEventListener("click", function (event) {
    event.preventDefault();
    show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
    if (id.trim().toLowerCase() === "sales") {
      // SEND FOR SALES FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          salesForm: "salesForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let searchTerm = _("search-term");
        let showSearch = _("show-search");

        searchTerm.onkeyup = function () {
          if (clean(searchTerm) > 0) {
            $.ajax({
              url: "./control/action.php",
              method: "POST",
              data: {
                searchItem: "searchItem",
                searchTerm: searchTerm.value,
              },
              beforeSend: function () {
                showSearch.innerHTML = loadIcon;
              },
              success: function (data) {
                showSearch.innerHTML = data;
              },
            }).done(function () {
              let saleItem = document.getElementsByName("saleaction");
              saleItem.forEach(function (el) {
                el.onclick = function () {
                  let itemId = el.id;
                  //   SHOW POPUP WITH ITEM DETAILS
                  popupShow.style.display = "block";
                  pClose.addEventListener("click", function () {
                    popupShow.style.display = "none";
                  });
                  $.ajax({
                    url: "./control/forms.php",
                    method: "POST",
                    data: {
                      fetchSaleItem: "fetchSaleItem",
                      itemId: itemId,
                    },
                    beforeSend: function () {
                      sPContent.innerHTML = `<div class="text-center"> ${loadIcon} Loading </div>`;
                    },
                    success: function (data) {
                      sPContent.innerHTML = data;
                    },
                  }).done(function () {
                    // DECLARE ALL FORM VARIABLES
                    let qtyPurchase = _("qty-purchase");
                    let comment = _("comment");
                    let amountCheckOpen = _("open-amount");
                    let discountedAmount = _("discounted-amount");
                    let showAmount = _("show-amount");
                    let sellingPrice = _("selling-price");
                    let saleForm = _("sale-form");
                    let paymentType = _("payment-type");
                    discountedAmount.disabled = true;
                    sPContent.style.width = "80%";
                    let sFError = _("form-sale-error");
                    let sSubmit = _("sales-submit");

                    {
                      qtyPurchase.addEventListener("click", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("change", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("keyup", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("blur", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("mouseup", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });

                      // TOOGLING DISCOUNTED PRICE
                      amountCheckOpen.addEventListener("change", function () {
                        if (this.checked === true) {
                          discountedAmount.disabled = false;
                        } else {
                          discountedAmount.disabled = true;
                          discountedAmount.value = "";
                        }
                      });
                    }
                    saleForm.addEventListener("submit", function (event) {
                      event.preventDefault();
                      if (
                        amountCheckOpen.checked === true &&
                        clean(discountedAmount) < 1
                      ) {
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = error(
                          "Discounted Amount can't be open and empty, kindly close if no discount giving"
                        );
                      } else if (
                        amountCheckOpen.checked === true &&
                        clean(comment) < 1
                      ) {
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = error(
                          "Comment can't be empty if discount field is open"
                        );
                      } else if (
                        clean(qtyPurchase) < 1 ||
                        clean(paymentType) < 1
                      ) {
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = error("Check payment Type or Qty");
                      } else {
                        // SEND
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = `${loadIcon}`;

                        $.ajax({
                          url: "./control/action.php",
                          method: "POST",
                          data: {
                            qty: qtyPurchase.value,
                            comment: comment.value,
                            discounted: discountedAmount.value,
                            sp: sellingPrice.value,
                            pt: paymentType.value,
                            itemId: itemId,
                            sellItem: "submiting sales",
                          },
                          beforeSend: function () {
                            sFError.style.visibility = "visible";
                            sFError.innerHTML = `${loadIcon}`;
                            sSubmit.innerHTML = `${loadIcon} Submiting`;
                            sSubmit.disabled = true;
                          },
                          success: function (data) {
                            sFError.style.visibility = "visible";
                            sFError.innerHTML = data;
                            sSubmit.innerHTML = `Submit`;
                            sSubmit.disabled = false;

                            if (
                              data.trim() ===
                              "<div class='text-success'>Sales Submitted Successfully</div>"
                            ) {
                              sSubmit.disabled = true;
                            }
                          },
                        });
                      }
                      // CHECK FOR QUANTITY
                      // IF THE VALUE IS UNCHECKED
                      // CHECK THE VALUE OF COMMENT
                      // THEN SEND FOR B VERIFICATION

                      // DB SHOULD CONTAINED
                      // SECTON TYPE
                      //   sales
                      //   engineering
                      //   internet
                      //   training
                      // Qty
                      // Amount
                      // itemId
                      // userid
                      // date
                      // comment
                    });
                  });
                };
              });
            });
          } else {
            showSearch.innerHTML = "";
          }
        };
      });
    } else if (id.trim().toLocaleLowerCase() === "internet") {
      // SEND FOR INTERNET FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          internetForm: "internetForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // DECLARE ALL FORM VARIABLES
        let internetForm = _("sale-internet");
        let type = _("type");
        let amountQty = _("amountQty");
        let qty = _("qty");
        let showAmount = _("show-amount");
        let amountCheckOpen = _("open-amount");
        let discountedAmount = _("discounted-amount");
        let comment = _("comment");
        let paymentType = _("payment-type");
        discountedAmount.disabled = true;
        let iSubmit = _("internet-submit");
        let iFError = _("form-internet-error");

        {
          let qAArray = [qty, amountQty];
          qAArray.forEach(function (el) {
            el.onkeyup = function () {
              showAmount.innerHTML = `N ${(
                amountQty.value * qty.value
              ).toLocaleString()}`;
            };
            el.onmouseup = function () {
              showAmount.innerHTML = `N ${(
                amountQty.value * qty.value
              ).toLocaleString()}`;
            };
          });

          // TOOGLING DISCOUNTED PRICE
          amountCheckOpen.addEventListener("change", function () {
            if (this.checked === true) {
              discountedAmount.disabled = false;
            } else {
              discountedAmount.disabled = true;
              discountedAmount.value = "";
            }
          });
        }
        internetForm.addEventListener("submit", function (event) {
          event.preventDefault();
          if (amountCheckOpen.checked === true && clean(discountedAmount) < 1) {
            iFError.style.visibility = "visible";
            iFError.innerHTML = error(
              "Discounted Amount can't be open and empty, kindly close if no discount giving"
            );
          } else if (
            clean(type) < 1 &&
            clean(amountQty) < 1 &&
            clean(qty) < 1 &&
            clean(comment) < 1 &&
            clean(paymentType) < 1
          ) {
            iFError.innerHTML = error("All fields required");
            iFError.style.visibility = "visible";
          } else {
            iFError.innerHTML = `${loadIcon}`;
            iFError.style.visibility = "visible";
            $.ajax({
              url: "./control/action.php",
              method: "POST",
              data: {
                internetSale: "internetSale",
                name: type.value,
                sp: amountQty.value,
                qty: qty.value,
                discounted: discountedAmount.value,
                comment: comment.value,
                pt: paymentType.value,
              },
              beforeSend: function () {
                iFError.innerHTML = `${loadIcon}`;
                iFError.style.visibility = "visible";
                iSubmit.disabled = true;
                iSubmit.innerHTML = `${loadIcon} Submiting`;
              },
              success: function (data) {
                iSubmit.disabled = false;
                iSubmit.innerHTML = `Submit`;
                iFError.innerHTML = data;
                iFError.style.visibility = "visible";
                if (
                  data.trim() ===
                  "<div class='text-success'>Sales Submitted Successfully</div>"
                ) {
                  iSubmit.disabled = true;
                }
              },
            });
          }
        });
      });
    } else if (id.trim().toLowerCase() === "engineering") {
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          engineeringForm: "engineeringForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // DECLARE ALL FORM VARIABLES
        let engineeringForm = _("sale-engineering");
        let type = _("type");
        let amountQty = _("amountQty");
        let qty = _("qty");
        let showAmount = _("show-amount");
        let amountCheckOpen = _("open-amount");
        let discountedAmount = _("discounted-amount");
        let comment = _("comment");
        let paymentType = _("payment-type");
        discountedAmount.disabled = true;
        let iSubmit = _("internet-submit");
        let iFError = _("form-internet-error");

        {
          let qAArray = [qty, amountQty];
          qAArray.forEach(function (el) {
            el.onkeyup = function () {
              showAmount.innerHTML = `N ${(
                amountQty.value * qty.value
              ).toLocaleString()}`;
            };
            el.onmouseup = function () {
              showAmount.innerHTML = `N ${(
                amountQty.value * qty.value
              ).toLocaleString()}`;
            };
          });

          // TOOGLING DISCOUNTED PRICE
          amountCheckOpen.addEventListener("change", function () {
            if (this.checked === true) {
              discountedAmount.disabled = false;
            } else {
              discountedAmount.disabled = true;
              discountedAmount.value = "";
            }
          });
        }
        engineeringForm.addEventListener("submit", function (event) {
          event.preventDefault();
          if (amountCheckOpen.checked === true && clean(discountedAmount) < 1) {
            iFError.style.visibility = "visible";
            iFError.innerHTML = error(
              "Discounted Amount can't be open and empty, kindly close if no discount giving"
            );
          } else if (
            clean(type) < 1 &&
            clean(amountQty) < 1 &&
            clean(qty) < 1 &&
            clean(comment) < 1 &&
            clean(paymentType) < 1
          ) {
            iFError.innerHTML = error("All fields required");
            iFError.style.visibility = "visible";
          } else {
            iFError.innerHTML = `${loadIcon}`;
            iFError.style.visibility = "visible";
            $.ajax({
              url: "./control/action.php",
              method: "POST",
              data: {
                engineering: "engineering",
                name: type.value,
                sp: amountQty.value,
                qty: qty.value,
                discounted: discountedAmount.value,
                comment: comment.value,
                pt: paymentType.value,
              },
              beforeSend: function () {
                iFError.innerHTML = `${loadIcon}`;
                iFError.style.visibility = "visible";
                iSubmit.disabled = true;
                iSubmit.innerHTML = `${loadIcon} Submiting`;
              },
              success: function (data) {
                iSubmit.disabled = false;
                iSubmit.innerHTML = `Submit`;
                iFError.innerHTML = data;
                iFError.style.visibility = "visible";
                if (
                  data.trim() ===
                  "<div class='text-success'>Sales Submitted Successfully</div>"
                ) {
                  iSubmit.disabled = true;
                }
              },
            });
          }
        });
      });
    } else if (id.trim().toLowerCase() === "training") {
      show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          trainingContainer: "trainingContainer",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // GET THE BUTTONS VARIBALES
        let btnForm = _("form");
        let btnTrainingFees = _("trainingfees");
        let btnCertificate = _("certificate");
        let showTraining = _("show-training-form");
        // TRAINING FORM AJAX
        btnForm.onclick = function () {
          $.ajax({
            url: "./control/forms.php",
            method: "POST",
            data: {
              trainingForm: "trainingForm",
            },
            beforeSend: function () {
              showTraining.innerHTML = `<div class="text-center m-3">${loadIcon}</div>`;
            },
            success: function (data) {
              showTraining.innerHTML = data;
            },
          }).done(function () {
            // VARIABLES FOR THE FORM
            let tForm = _("training-form");
            let regNo = _("regno");
            let fullname = _("fullname");
            let phone = _("phone");
            let amount = _("amount");
            let programType = _("type");
            let comment = _("comment");
            let paymentType = _("payment-type");
            let chargePrice = _("charge-price");
            let paymentStatus = _("payment-status");
            let btnForm = _("btn-training-form");
            let tFError = _("training-form-error");

            tForm.onsubmit = function (event) {
              event.preventDefault();
              if (
                clean(regNo) < 1 ||
                clean(fullname) < 1 ||
                clean(phone) < 1 ||
                clean(amount) < 1 ||
                clean(programType) < 1 ||
                clean(comment) < 1 ||
                clean(paymentType) < 1 ||
                clean(chargePrice) < 1 ||
                clean(paymentStatus) < 1
              ) {
                console.log(
                  regNo,
                  fullname,
                  phone,
                  amount,
                  programType,
                  comment,
                  paymentType,
                  chargePrice,
                  paymentStatus
                );
                tFError.style.visibility = "visible";
                tFError.innerHTML = error("ALL FIELD(S) REQUIRED");
              } else if (clean(phone) < 11) {
                tFError.style.visibility = "visible";
                tFError.innerHTML = error("INVALID PHONE NUMBER");
              } else if (Number(amount.value) > Number(chargePrice.value)) {
                tFError.style.visibility = "visible";
                tFError.innerHTML = error(
                  "AMOUNT PAID HIGHER THAN CHARGE FEES"
                );
              } else {
                tFError.style.visibility = "visible";
                tFError.innerHTML = `${loadIcon}`;
                // SEND AJAX
                $.ajax({
                  url: "./control/action.php",
                  method: "POST",
                  data: {
                    saleTrainingForm: "saleTrainingForm",
                    regNo: regNo.value,
                    fullname: fullname.value,
                    phone: phone.value,
                    amount: amount.value,
                    programType: programType.value,
                    comment: comment.value,
                    paymentType: paymentType.value,
                    chargePrice: chargePrice.value,
                    paymentStatus: paymentStatus.value,
                  },
                  beforeSend: function () {
                    tFError.style.visibility = "visible";
                    tFError.innerHTML = `${loadIcon}`;
                    btnForm.disabled = true;
                    btnForm.innerHTML = `${loadIcon} submiting`;
                  },
                  success: function (data) {
                    if (
                      data.trim() ===
                      "<div class='text-success'>Form Submitted Successfully</div>"
                    ) {
                      tFError.style.visibility = "visible";
                      tFError.innerHTML = data;
                      btnForm.disabled = true;
                      btnForm.innerHTML = "Submitted Sucessfully";
                      tForm.reset();
                    } else {
                      tFError.style.visibility = "visible";
                      tFError.innerHTML = data;
                      btnForm.disabled = false;
                      btnForm.innerHTML = "Submit";
                      if (
                        data.trim() ===
                        "<div class='text-success'>Sales Submitted Successfully</div>"
                      ) {
                        btnForm.disabled = true;
                      }
                    }
                  },
                });
              }
            };
          });
        };
        // TRAINING FORM
        btnTrainingFees.onclick = function () {
          $.ajax({
            url: "./control/forms.php",
            method: "POST",
            data: {
              trainingFessForm: "trainingFeesForm",
            },
            beforeSend: function () {
              showTraining.innerHTML = `<div class="text-center m-3">${loadIcon}</div>`;
            },
            success: function (data) {
              showTraining.innerHTML = data;
            },
          }).done(function () {
            // DECLARE THE VARIABLE
            let sTFForm = _("show-reg-form");
            let regNo = _("regno");
            regNo.onchange = function () {
              sTFForm.innerHTML = `<div class="text-center"> ${loadIcon} </div>`;
              // SENDING REQUEST
              if (regNo.value.trim() !== "") {
                $.ajax({
                  url: "./control/forms.php",
                  method: "POST",
                  data: { showRegForm: "showRegForm", regNo: regNo.value },
                  beforeSend: function () {
                    sTFForm.innerHTML = `<div class="text-center"> ${loadIcon} </div>`;
                  },
                  success: function (data) {
                    sTFForm.innerHTML = data;
                  },
                }).done(function () {
                  $(".custom-file-input").on("change", function () {
                    var fileName = $(this).val().split("\\").pop();
                    $(this)
                      .siblings(".custom-file-label")
                      .addClass("selected")
                      .html(fileName);
                  });

                  // DECLARE VARIABLES
                  let tFForm = _("trainingFees");
                  let fullname = _("fullname");
                  let phone = _("phone");
                  let email = _("email");
                  let studentAddress = _("student-address");
                  let checkBoxGuardianName = _("guardian-name-sameas");
                  let guardianName = _("guardian-name");
                  let checkBoxGuardianAddress = _("guardian-address-sameas");
                  let guardianAddress = _("guardian-address");
                  let programType = _("program-type");
                  let amountCharge = _("amount-charged");
                  let amountPaid = _("amount-paid");
                  let comment = _("comment");
                  let paymentStatus = _("payment-status");
                  let fillForm = _("fillForm");
                  let paymentType = _("payment-type");
                  let btnTF = _("btn-training-fees");
                  let formNo = _("form-no");
                  let tFFormError = _("training-fees-error");

                  checkBoxGuardianName.onchange = function () {
                    if (this.checked === true) {
                      // CHECK IF FULL NAME IS NOT EMPTY
                      if (clean(fullname) < 1) {
                        this.checked = false;
                        guardianName.disabled = true;
                      } else {
                        guardianName.value = fullname.value;
                        this.checked = true;
                        guardianName.disabled = true;
                      }
                    } else {
                      guardianName.value = "";
                      guardianName.disabled = false;
                    }
                  };

                  // GUARDIAN ADDRESS CHECKBOX
                  checkBoxGuardianAddress.onchange = function () {
                    if (this.checked === true) {
                      // CHECK IF FULL NAME IS NOT EMPTY
                      if (clean(fullname) < 1) {
                        this.checked = false;
                        guardianAddress.disabled = true;
                      } else {
                        guardianAddress.value = studentAddress.value;
                        this.checked = true;
                        guardianAddress.disabled = true;
                      }
                    } else {
                      guardianAddress.value = "";
                      guardianAddress.disabled = false;
                    }
                  };

                  tFForm.onsubmit = function (event) {
                    event.preventDefault();

                    // CHECK FOR EMPTY VALUE, NUMBER LENGTH
                    if (
                      clean(fullname) < 1 ||
                      clean(phone) < 1 ||
                      clean(email) < 1 ||
                      clean(studentAddress) < 1 ||
                      clean(guardianName) < 1 ||
                      clean(guardianAddress) < 1 ||
                      clean(programType) < 1 ||
                      clean(amountCharge) < 1 ||
                      clean(amountPaid) < 1 ||
                      clean(comment) < 1 ||
                      clean(paymentType) < 1
                    ) {
                      tFFormError.innerHTML = error("ALL FIELDS REQUIRED");
                      tFFormError.style.visibility = "visible";
                    } else if (clean(phone) < 11) {
                      tFFormError.innerHTML = error("INVALID PHONE NUMBER");
                      tFFormError.style.visibility = "visible";
                    } else if (
                      Number(amountPaid.value) > Number(amountCharge.value)
                    ) {
                      tFFormError.innerHTML = error(
                        "AMOUNT PAID CAN'T BE GREATER THAN THE CHARGES"
                      );
                      tFFormError.style.visibility = "visible";
                    } else {
                      // CHECK FILES PROPERTY
                      let files = fillForm.files;
                      if (files.length > 0) {
                        // IF FILES IS CHOOSEN
                        let type = files[0].type;
                        let name = files[0].name;
                        let size = files[0].size / 1000000;
                        if (type === "application/pdf") {
                          // CHECK THE FILES SELECTED
                          const fd = new FormData();
                          fd.append("fillFile", files[0]);
                          fd.append("fullname", fullname.value);
                          fd.append("phone", phone.value);
                          fd.append("email", email.value);
                          fd.append("studentAddress", studentAddress.value);
                          fd.append("guardianName", guardianName.value);
                          fd.append("guardianAddress", guardianAddress.value);
                          fd.append("programType", programType.value);
                          fd.append("amountCharge", amountCharge.value);
                          fd.append("paymentStatus", paymentStatus.value);
                          fd.append("amountPaid", amountPaid.value);
                          fd.append("comment", comment.value);
                          fd.append("paymentType", paymentType.value);
                          fd.append("regNo", formNo.value);
                          fd.append("trainingFeesSubmit", "trainingFeesSubmit");

                          $.ajax({
                            url: "./control/action.php",
                            method: "POST",
                            processData: false,
                            contentType: false,
                            data: fd,
                            beforeSend: function () {
                              btnTF.disabled = true;
                              btnTF.innerHTML = `${loadIcon} Submiting`;
                              tFFormError.innerHTML = `${loadIcon}`;
                              tFFormError.style.visibility = "visible";
                            },
                            success: function (data) {
                              if (
                                data.trim() ===
                                "<div class='text-success'>Details Submited Successfully</div>"
                              ) {
                                btnTF.disabled = true;
                                btnTF.innerHTML = `Successful`;
                                tFForm.reset();
                              } else {
                                tFFormError.innerHTML = data;
                                tFFormError.style.visibility = "visible";
                                btnTF.disabled = false;
                                btnTF.innerHTML = `Submit`;
                              }
                            },
                          });
                        } else {
                          tFFormError.innerHTML =
                            "INVALID FILE TYPE SELECTED PDF ONLY";
                          tFFormError.style.visibility = "visible";
                        }
                      } else {
                        tFFormError.innerHTML = "NO FILL FILE SELECTED";
                        tFFormError.style.visibility = "visible";
                      }
                    }
                  };
                });
              }
            };
          });
        };
        // CERTIFICATE FORM
        btnCertificate.onclick = function () {
          $.ajax({
            url: "./control/forms.php",
            method: "POST",
            data: {
              certificateForm: "certificateForm",
            },
            beforeSend: function () {
              showTraining.innerHTML = `<div class="text-center m-3">${loadIcon}</div>`;
            },
            success: function (data) {
              showTraining.innerHTML = data;
            },
          });
        };
      });
    } else if (id.trim().toLowerCase() === "credit") {
      // SEND FOR SALES FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          salesForm: "salesForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let searchTerm = _("search-term");
        let showSearch = _("show-search");

        searchTerm.onkeyup = function () {
          if (clean(searchTerm) > 0) {
            $.ajax({
              url: "./control/action.php",
              method: "POST",
              data: {
                searchItem: "searchItem",
                searchTerm: searchTerm.value,
              },
              beforeSend: function () {
                showSearch.innerHTML = loadIcon;
              },
              success: function (data) {
                showSearch.innerHTML = data;
              },
            }).done(function () {
              let saleItem = document.getElementsByName("saleaction");
              saleItem.forEach(function (el) {
                el.onclick = function () {
                  let itemId = el.id;
                  //   SHOW POPUP WITH ITEM DETAILS
                  popupShow.style.display = "block";
                  pClose.addEventListener("click", function () {
                    popupShow.style.display = "none";
                  });
                  $.ajax({
                    url: "./control/forms.php",
                    method: "POST",
                    data: {
                      debtorFetchSaleItem: "debtorFetchSaleItem",
                      itemId: itemId,
                    },
                    beforeSend: function () {
                      sPContent.innerHTML = `<div class="text-center"> ${loadIcon} Loading </div>`;
                    },
                    success: function (data) {
                      sPContent.innerHTML = data;
                    },
                  }).done(function () {
                    // DECLARE ALL FORM VARIABLES
                    let qtyPurchase = _("qty-purchase");
                    let comment = _("comment");
                    let amountCheckOpen = _("open-amount");
                    let discountedAmount = _("discounted-amount");
                    let showAmount = _("show-amount");
                    let sellingPrice = _("selling-price");
                    let saleForm = _("sale-form");
                    let paymentType = _("payment-type");
                    discountedAmount.disabled = true;
                    sPContent.style.width = "80%";
                    let sFError = _("form-sale-error");
                    let sSubmit = _("sales-submit");

                    {
                      qtyPurchase.addEventListener("click", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("change", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("keyup", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("blur", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });
                      qtyPurchase.addEventListener("mouseup", function () {
                        let qty = qtyPurchase.value;
                        showAmount.innerHTML = (
                          Number(qty) * Number(sellingPrice.value)
                        ).toLocaleString();
                      });

                      // TOOGLING DISCOUNTED PRICE
                      amountCheckOpen.addEventListener("change", function () {
                        if (this.checked === true) {
                          discountedAmount.disabled = false;
                        } else {
                          discountedAmount.disabled = true;
                          discountedAmount.value = "";
                        }
                      });
                    }
                    saleForm.addEventListener("submit", function (event) {
                      event.preventDefault();
                      if (
                        amountCheckOpen.checked === true &&
                        clean(discountedAmount) < 1
                      ) {
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = error(
                          "Discounted Amount can't be open and empty, kindly close if no discount giving"
                        );
                      } else if (
                        amountCheckOpen.checked === true &&
                        clean(comment) < 1
                      ) {
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = error(
                          "Comment can't be empty if discount field is open"
                        );
                      } else if (
                        clean(qtyPurchase) < 1 ||
                        clean(paymentType) < 1
                      ) {
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = error("Check payment Type or Qty");
                      } else {
                        // SEND
                        sFError.style.visibility = "visible";
                        sFError.innerHTML = `${loadIcon}`;

                        $.ajax({
                          url: "./control/action.php",
                          method: "POST",
                          data: {
                            qty: qtyPurchase.value,
                            comment: comment.value,
                            discounted: discountedAmount.value,
                            sp: sellingPrice.value,
                            pt: paymentType.value,
                            itemId: itemId,
                            sellDebtor: "sellDebtor",
                          },
                          beforeSend: function () {
                            sFError.style.visibility = "visible";
                            sFError.innerHTML = `${loadIcon}`;
                            sSubmit.innerHTML = `${loadIcon} Submiting`;
                            sSubmit.disabled = true;
                          },
                          success: function (data) {
                            sFError.style.visibility = "visible";
                            sFError.innerHTML = data;
                            sSubmit.innerHTML = `Submit`;
                            sSubmit.disabled = false;
                          },
                        });
                      }
                    });
                  });
                };
              });
            });
          } else {
            showSearch.innerHTML = "";
          }
        };
      });
    } else if (id.trim().toLowerCase() === "search") {
      // SEND FOR SEARCH FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          revenueSearchForm: "revenueSearchForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let by = _("by");
        if (by.value === "all") {
          // send for all search form
        } else if (by.value === "branch") {
          // Sench for branch form
        }
      });
    } else if (id.trim().toLowerCase() === "all-records") {
      // SEND FOR ALL RECORDS FORM
      $.ajax({
        url: forms,
        method: "POST",
        data: {
          allRevenueRecords: "allRevenueRecords",
        },
        beforeSend: function () {
          show.innerHTML = loadIcon;
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let sARecord = _("show-all-revenue");
        let btnRevenue = document.getElementsByName("btn-revenue");
        btnRevenue.forEach(function (el) {
          el.onclick = function () {
            sARecord.innerHTML = loadIcon;
            let id = el.id;
            if (id.trim().toLowerCase() === "all-records") {
              // ALL RECORDS REQUEST
              $.ajax({
                url: action,
                method: "POST",
                data: {
                  fetchAllRevenueRecords: "fetchAllRevenueRecords",
                },
                beforeSend: function () {
                  sARecord.innerHTML = loadIcon;
                },
                success: function (data) {
                  sARecord.innerHTML = data;
                  $("#page-table").DataTable({
                    lengthMenu: [
                      [5, 10, 25, 50, -1],
                      [5, 10, 25, 50, "All"],
                    ],
                  });
                },
              });
            } else if (id.trim().toLowerCase() === "record-by-branch") {
              $.ajax({
                url: forms,
                method: "POST",
                data: {
                  recordByBranch: "recordByBranch",
                },
                beforeSend: function () {
                  sARecord.innerHTML = loadIcon;
                },
                success: function (data) {
                  sARecord.innerHTML = data;
                },
              }).done(function () {
                let branch = _("branch");
                let sShow = _("show-branch-record");
                branch.onchange = function (event) {
                  let bId = this.value;
                  // BRANCH RECORDS
                  $.ajax({
                    url: action,
                    method: "POST",
                    data: {
                      showBranchRecord: "showBranchRecord",
                      bId: bId,
                    },
                    beforeSend: function () {
                      sShow.innerHTML = loadIcon;
                    },
                    success: function (data) {
                      sShow.innerHTML = data;
                    },
                  }).done(function () {
                    $("#page-table").DataTable({
                      lengthMenu: [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"],
                      ],
                    });
                  });
                };
              });
            } else if (id.trim().toLowerCase() === "search-record") {
              $.ajax({
                url: forms,
                method: "POST",
                data: {
                  searchRecord: "searchRecord",
                },
                beforeSend: function () {
                  sARecord.innerHTML = loadIcon;
                },
                success: function (data) {
                  sARecord.innerHTML = data;
                },
              });
            }
          };
        });
      });
    } else if (id.trim().toLowerCase() === "expenses") {
      //  SEND FOR EXPESES FORM
      $.ajax({
        url: forms,
        method: "POST",
        data: {
          expenses: "expenses",
        },
        beforeSend: function () {
          show.innerHTML = loadIcon;
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // DECLEARE VARIABLES
        let btnExpenses = document.getElementsByName("btn-expenses");
        let sShow = _("sub-show");
        btnExpenses.forEach(function (el) {
          el.onclick = function () {
            let id = el.id;
            sShow.innerHTML = loadIcon;
            if (id.trim().toLowerCase() === "add-expenses") {
              $.ajax({
                url: forms,
                method: "POST",
                data: {
                  expensesForm: "expenses",
                },
                beforeSend: function () {
                  sShow.innerHTML = loadIcon;
                },
                success: function (data) {
                  sShow.innerHTML = data;
                },
              }).done(function () {
                let amount = _("amount");
                let section = _("section");
                let description = _("description");
                let btnSubmit = _("btn-submit");
                let eForm = _("expenses-form");
                let eExpenses = _("error-expenses");
                eForm.onsubmit = function (event) {
                  event.preventDefault();
                  // CHECK FOR EMPTY FILEDS
                  if (
                    clean(amount) > 0 &&
                    clean(section) > 0 &&
                    clean(description) > 0
                  ) {
                    eExpenses.innerHTML = loadIcon;
                    eExpenses.style.visibility = "visible";
                    // SEND

                    $.ajax({
                      url: action,
                      method: "POST",
                      data: {
                        section: section.value,
                        amount: amount.value,
                        description: description.value,
                        addingExpenses: "adding Expenses",
                      },
                      beforeSend: function () {
                        btnSubmit.innerHTML = `${loadIcon} Submitting..`;
                        btnSubmit.disabled = true;
                      },
                      success: function (data) {
                        btnSubmit.innerHTML = "Submit";
                        btnSubmit.disabled = false;
                        eExpenses.innerHTML = data;
                        if (
                          data.trim() ===
                          "<div class='text-success'>EXPENSES SUBMITTED SUCCESSFULLY</div>"
                        ) {
                          eForm.reset();
                        } else {
                          console.log(data);
                        }
                      },
                    });
                  } else {
                    eExpenses.innerHTML = error("ALL FIELDS REQUIRED");
                    eExpenses.style.visibility = "visible";
                  }
                };
              });
            } else if (id.trim().toLowerCase() === "all-expenses") {
              $.ajax({
                url: action,
                method: "POST",
                data: {
                  allExpenses: "ALL EXPENSES",
                },
                beforeSend: function name() {
                  sShow.innerHTML = loadIcon;
                },
                success: function (data) {
                  sShow.innerHTML = data;
                },
              });
            } else if (id.trim().toLowerCase() === "daily-expenses") {
              // DAILY EXPENSES
              $.ajax({
                url: action,
                method: "POST",
                data: {
                  dailyExpenses: "Daily Expenses",
                },
                beforeSend: function () {
                  sShow.innerHTML = loadIcon;
                },
                success: function (data) {
                  sShow.innerHTML = data;
                },
              });
            } else if (id.trim().toLowerCase() === "expenses-by-branch") {
              // SEND FOR EXPENSES BY BRANCH
              $.ajax({
                url: forms,
                method: "POST",
                data: {
                  expensesByBranchForm: "Expenses By Branch",
                },
                beforeSend: function () {
                  sShow.innerHTML = loadIcon;
                },
                success: function (data) {
                  sShow.innerHTML = data;
                },
              }).done(function () {
                // VARIABLES
                let ebbForm = _("ebb-form");
                let branch = _("branch");
                let range = _("range");
                let ebbBtn = _("btn-submit");
                let showExpenses = _("show-branch-expenses");
                ebbForm.onsubmit = function (event) {
                  event.preventDefault();
                  // CHECK FOR EMPTY
                  if (clean(branch) > 0 && clean(range) > 0) {
                    // SEND
                    $.ajax({
                      url: action,
                      method: "POST",
                      data: {
                        branch: branch.value,
                        range: range.value,
                        expensesByBranch: "ExpensesByBranch",
                      },
                      beforeSend: function () {
                        ebbBtn.innerHTML = `${loadIcon} Getting..`;
                        ebbBtn.disabled = true;
                        showExpenses.innerHTML = loadIcon;
                      },
                      success: function (data) {
                        showExpenses.innerHTML = data;
                        ebbBtn.disabled = false;
                        ebbBtn.innerHTML = "Get";
                      },
                    });
                  } else {
                    showExpenses.innerHTML = error("ALL FIELDS REQUIRED");
                  }
                };
              });
            }
          };
        });
      });
    } else if (id.trim().toLowerCase() === "return") {
      // SEND FOR RETURN FORM
      $.ajax({
        url: action,
        method: "POST",
        data: {
          itemReturn: "itemReturn",
        },
        beforeSend: function () {},
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // DECLARE ALL THE VARIABLES
        let actions = document.getElementsByName("action");
        actions.forEach(function (el) {
          el.onchange = function () {
            let id = el.id;
            //  SEND FOR RETURN FORM
            $.ajax({
              url: forms,
              method: "POST",
              data: {
                returnForm: "returnForm",
                id: id,
              },
              beforeSend: function () {
                popupShow.style.display = "block";
                sPContent.innerHTML = loadIcon;
              },
              success: function (data) {
                sPContent.innerHTML = data;
              },
            });
          };
        });
      });
    }
  });
});
// TABLE PAGGINATION
$(document).ready(function () {
  $("#revenue-table").DataTable({
    lengthMenu: [
      [5, 10, 25, 50, -1],
      [5, 10, 25, 50, "All"],
    ],
  });
});
