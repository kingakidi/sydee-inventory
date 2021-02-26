let pLink = document.getElementsByName("p-link");
let show = _("show-item");
let loadIcon = '<i class="fa fa-spinner fa-spin"></i>';
let popupShow = _("popup-page");
let sPContent = _("show-popup-content");
let pClose = _("popup-close");
let forms = "./control/forms.php";
let action = "./control/action.php";

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
    }
  });
});
