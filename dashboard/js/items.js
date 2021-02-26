let pLink = document.getElementsByName("p-link");
let show = _("show-item");
let loadIcon = '<i class="fa fa-spinner fa-spin"></i>';
let forms = "./control/forms.php";
let action = "./control/action.php";
let popupPage = _("popup-page");
let popupContent = _("show-popup-content");
let popupClose = _("popup-close");

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
// MORE ITEM VARIABLE
let moreItems = document.getElementsByName("btn-item-more");

pLink.forEach(function (element) {
  element.addEventListener("click", function () {
    show.innerHTML = '<i class="fa fa-spinner fa-spin fa-2x"></i>';
    let id = element.id;

    if (id === "newitem") {
      // SEND FOR NEW ITEM FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          newItemForm: "newItemForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-2x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let category = _("category");
        let subCategory = _("sub-category");
        let itemName = _("item-name");
        let qty = _("qty");
        let costPrice = _("cost-price");
        let sellingPrice = _("selling-price");
        let itemForm = _("item-form");
        let image = _("image");
        let ife = _("item-form-error");
        let bif = _("btn-item");

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
          var fileName = $(this).val().split("\\").pop();
          $(this)
            .siblings(".custom-file-label")
            .addClass("selected")
            .html(fileName);
        });
        category.addEventListener("change", function () {
          subCategory.innerHTML = '<option value="">Loading...</option>';
          catId = this.value;
          // SEND AJAX FOR SUB CATEGORY
          $.ajax({
            url: "./control/action.php",
            method: "POST",
            data: {
              subCategoryList: catId,
            },
            beforeSend: function () {
              subCategory.innerHTML = '<option value="">Loading...</option>';
            },
            success: function (data) {
              subCategory.innerHTML = data;
            },
          });
        });

        itemForm.addEventListener("submit", function (event) {
          event.preventDefault();
          let files = image.files;

          // CLEAN ALL EMPTY
          if (
            clean(category) > 0 &&
            clean(subCategory) &&
            clean(itemName) > 0 &&
            clean(qty) > 0 &&
            clean(costPrice) > 0 &&
            clean(sellingPrice) > 0 &&
            files.length > 0
          ) {
            // CHECK IMAGE TYPE && SIZE
            let name = files[0].name;
            let size = files[0].size;
            let type = files[0].type;

            if (size > 100000) {
              ife.innerHTML = "Image is too big Max of 100Kb";
              ife.style.visibility = "visible";
            } else if (
              type.toLowerCase() === "image/jpeg" ||
              type.toLowerCase() === "image/jpg" ||
              type.toLowerCase() === "image/png"
            ) {
              //   SEND FILES TO DB

              let category = _("category");
              let subCategory = _("sub-category");
              let itemName = _("item-name");
              let qty = _("qty");
              let costPrice = _("cost-price");
              let sellingPrice = _("selling-price");
              let itemForm = _("item-form");
              let image = _("image");

              const fd = new FormData();
              fd.append("image", files[0]);
              fd.append("category", category.value);
              fd.append("subCategory", subCategory.value);
              fd.append("itemName", itemName.value);
              fd.append("qty", qty.value);
              fd.append("costPrice", costPrice.value);
              fd.append("sellingPrice", sellingPrice.value);
              fd.append("submitItemForm", "itemForm");

              $.ajax({
                url: "./control/action.php",
                method: "POST",
                processData: false,
                contentType: false,
                data: fd,
                beforeSend: function () {
                  bif.innerHTML = `${loadIcon} Adding`;
                  bif.disabled = true;
                },
                success: function (data) {
                  ife.innerHTML = data;
                  ife.style.visibility = "visible";
                  bif.innerHTML = `Submit`;
                  bif.disabled = false;
                },
              });
            } else {
              ife.innerHTML = "Invalid file selected jpg, jpeg or png only";
              ife.style.visibility = "visible";
            }
          } else {
            ife.innerHTML = "ALL FIELD(s) REQUIRED";
            ife.style.visibility = "visible";
          }
        });
      });
    } else if (id === "createbranch") {
      // SEND FOR CREATE BRANCH FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          createbranchForm: "createbranchForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-2x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(
        // WHEN FORM IS SUCCESSFULLY FETCH
        function () {
          let branchName = _("branch-name");
          let branchForm = _("branch-form");
          let address = _("address");
          let facilityType = _("facility-type");
          let nOfShops = _("number-of-shops");
          let rentalCost = _("rental-cost");
          let expiringDate = _("date");
          let password = _("password");
          let bFE = _("branch-form-error");
          let btnBF = _("btn-branch");
          branchName.style.textTransform = "capitalize";
          address.style.textTransform = "capitalize";

          branchForm.addEventListener("submit", function (event) {
            event.preventDefault();
            if (
              clean(branchName) > 0 &&
              clean(address) > 0 &&
              clean(facilityType) > 0 &&
              clean(nOfShops) > 0 &&
              clean(rentalCost) > 0 &&
              clean(expiringDate) > 0 &&
              clean(password) > 0
            ) {
              bFE.innerHTML = "";
              bFE.style.visibility = "visible";
              // SEND AJAX REQUEST
              $.ajax({
                url: "./control/action.php",
                method: "POST",
                data: {
                  bName: branchName.value,
                  address: address.value,
                  fType: facilityType.value,
                  nOfShops: nOfShops.value,
                  rentalCost: rentalCost.value,
                  expiringDate: expiringDate.value,
                  password: password.value,
                  createBranch: "createBranch",
                },
                beforeSend: function () {
                  btnBF.innerHTML = `${loadIcon} Creating`;
                  btnBF.disabled = true;
                },
                success: function (data) {
                  bFE.innerHTML = data;
                  bFE.style.visibility = "visible";
                  btnBF.disabled = false;
                  btnBF.innerHTML = "CREATE";
                },
              });
            } else {
              bFE.innerHTML = "ALL FIELD(s) REQUIRED";
              bFE.style.visibility = "visible";
            }
          });
        }
      );
    } else if (id === "itemtobranch") {
      // SEND FOR ITEM TO BRANCH FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          addItemToBranch: "addItemToBranch",
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // DECLARING VARIALES
        let iBranchName = _("branch-name");
        let iItemName = _("item-name");
        let sIInfo = _("show-item-info");
        let category = _("category");
        let subCategory = _("sub-category");
        let = iTBForm = _("item-to-branch-form");

        // ON CATEGORY CHANGE
        category.addEventListener("change", function () {
          subCategory.innerHTML =
            '<option value="" selected disabled>Loading...</option>';
          catId = this.value;
          // SEND AJAX FOR SUB CATEGORY
          $.ajax({
            url: "./control/action.php",
            method: "POST",
            data: {
              subCategoryList: catId,
            },
            beforeSend: function () {
              subCategory.innerHTML = '<option value="">Loading...</option>';
            },
            success: function (data) {
              subCategory.innerHTML = data;
            },
          });
        });
        // ON SUB CATEGORY CHANGE
        subCategory.addEventListener("change", function () {
          iItemName.innerHTML =
            '<option value="" selected disabled>Loading...</option>';
          catId = this.value;
          // SEND AJAX FOR SUB CATEGORY
          $.ajax({
            url: "./control/action.php",
            method: "POST",
            data: {
              itemSubCategoryList: catId,
            },
            beforeSend: function () {
              iItemName.innerHTML = '<option value="">Loading...</option>';
            },
            success: function (data) {
              iItemName.innerHTML = data;
            },
          }).done({
            // LIST YOUR VARIABLES
            function() {},
          });
        });

        // ON ITEM CHANGE
        iItemName.addEventListener("change", function () {
          let id = this.value;
          // FECTH ITEM DETAILS FROM DATABASE
          $.ajax({
            url: "./control/action.php",
            method: "POST",
            data: {
              itemIdToFetch: id,
            },
            beforeSend: function () {
              sIInfo.innerHTML = loadIcon;
            },
            success: function (data) {
              sIInfo.innerHTML = data;
            },
          }).done(function () {
            let qta = _("qty-to-assign");
            let qty = _("qty");
            let qtyError = _("qty-error");
            let cp = _("cost-price");
            let sp = _("selling-price");
            let ife = _("item-form-error");
            let btForm = _("btn-item-form");
            qta.onkeyup = function () {
              //    CHECK THE VALUE IN STOCK AND THE VALUE OF QUANTITY ASSIGN
              if (Number(qta.value) > Number(qty.value)) {
                qta.value = qty.value;
                $tCost = (
                  Number(cp.value) * Number(qta.value)
                ).toLocaleString();
                $tSell = (
                  Number(sp.value) * Number(qta.value)
                ).toLocaleString();
                $tProfit = (
                  Number(sp.value) * Number(qta.value) -
                  Number(cp.value) * Number(qta.value)
                ).toLocaleString();
                qtyError.innerHTML = `<div class='text-primary'> 
                                            Quantity Remaining:  ${
                                              Number(qty.value) -
                                              Number(qta.value)
                                            } <br> 
                                            Cost: N ${$tCost} <br> 
                                            Expected Sales Cost: N ${$tSell} <br> 
                                            Expected Profit: N ${$tProfit}
                                            </div>`;
                qtyError.style.visibility = "visible";
              } else {
                $tCost = (
                  Number(cp.value) * Number(qta.value)
                ).toLocaleString();
                $tSell = (
                  Number(sp.value) * Number(qta.value)
                ).toLocaleString();
                $tProfit = (
                  Number(sp.value) * Number(qta.value) -
                  Number(cp.value) * Number(qta.value)
                ).toLocaleString();
                qtyError.innerHTML = `<div class='text-primary'> 
                                            Quantity Remaining:  ${
                                              Number(qty.value) -
                                              Number(qta.value)
                                            } <br> 
                                            Cost: N ${$tCost} <br> 
                                            Expected Sales Cost: N ${$tSell} <br> 
                                            Expected Profit: N ${$tProfit}
                                            </div>`;
                qtyError.style.visibility = "visible";
              }
            };

            iTBForm.addEventListener("submit", function (event) {
              event.preventDefault();

              if (
                clean(iBranchName) > 0 &&
                clean(iItemName) > 0 &&
                clean(qta)
              ) {
                // SEND TO AJAX
                ife.innerHTML = "GOOD TO GO";
                ife.style.visibility = "visible";
                // SEND AJAX TO BACK END
                $.ajax({
                  url: "./control/action.php",
                  method: "POST",
                  data: {
                    iBranchName: iBranchName.value,
                    iItemName: iItemName.value,
                    qta: qta.value,
                    sendItemToBranch: "sendItemToBranch",
                  },
                  beforeSend: function () {
                    btForm.disabled = true;
                    btForm.innerHTML = `${loadIcon} Sending..`;
                    ife.innerHTML = loadIcon;
                  },
                  success: function (data) {
                    ife.innerHTML = data;
                    ife.style.visibility = "visibility";
                    btForm.disabled = false;
                    btForm.innerHTML = `Submit`;
                  },
                });
              } else {
                ife.innerHTML = "ALL FIELD(S) REQUIRED";
                ife.style.visibility = "visible";
              }
            });
          });
        });
      });
    } else if (id === "branchitems") {
      //  BRANCH ITEM FORM
      $.ajax({
        url: forms,
        method: "POST",
        data: {
          branchItemForm: "branchItemForm",
        },
        beforeSend: function () {
          show.innerHTML = show.innerHTML =
            '<i class="fa fa-spinner fa-spin fa-2x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let branch = _("branch");
        let sBItem = _("show-branch-items");
        branch.onchange = function (event) {
          let bId = this.value;
          // SEND FOR BRANCH DETAILS
          $.ajax({
            url: action,
            method: "POST",
            data: {
              individualBranchItems: "individualBranchItems",
              bId: bId,
            },
            beforeSend: function () {
              sBItem.innerHTML = loadIcon;
            },
            success: function (data) {
              sBItem.innerHTML = data;
            },
          });
        };
      });
    }
  });
});

// MORE BUTTON
moreItems.forEach(function (el) {
  el.onclick = function () {
    let sShow = _("sub-show");
    sShow.innerHTML = loadIcon;

    if (el.id === "all-items") {
      $.ajax({
        url: action,
        method: "POST",
        data: {
          allItems: "allItems",
        },
        beforeSend: function name() {
          sShow.innerHTML = loadIcon;
        },
        success: function (data) {
          sShow.innerHTML = data;
        },
      });
    } else if (el.id == "store-items") {
      $.ajax({
        url: action,
        method: "POST",
        data: {
          allStoreItems: "allStoreItems",
        },
        beforeSend: function name() {
          sShow.innerHTML = loadIcon;
        },
        success: function (data) {
          sShow.innerHTML = data;
        },
      }).done(function () {
        // DECLARE VARIABLES
        let actions = document.getElementsByName("actions");
        actions.forEach(function (el) {
          el.onchange = function () {
            let id = el.id;
            let value = el.value;
            popupPage.style.display = "block";
            popupContent.innerHTML = loadIcon;
            popupClose.onclick = function () {
              popupPage.style.display = "none";
            };
            if (value === "edit") {
              // SHOW POPUP WITH IT CONTENT
              $.ajax({
                url: forms,
                method: "POST",
                data: {
                  editItemsForm: "editItemForm",
                  id: id,
                },
                beforeSend: function () {
                  popupContent.innerHTML = loadIcon;
                },
                success: function (data) {
                  popupContent.innerHTML = data;
                },
              }).done(function () {
                let category = _("category");
                let subCategory = _("sub-category");
                let itemName = _("item-name");
                let qty = _("qty");
                let costPrice = _("cost-price");
                let sellingPrice = _("selling-price");
                let itemForm = _("item-form");
                let image = _("image");
                let ife = _("item-form-error");
                let bif = _("btn-item");

                // Add the following code if you want the name of the file appear on select
                $(".custom-file-input").on("change", function () {
                  var fileName = $(this).val().split("\\").pop();
                  $(this)
                    .siblings(".custom-file-label")
                    .addClass("selected")
                    .html(fileName);
                });
                category.addEventListener("change", function () {
                  subCategory.innerHTML =
                    '<option value="">Loading...</option>';
                  catId = this.value;
                  // SEND AJAX FOR SUB CATEGORY
                  $.ajax({
                    url: "./control/action.php",
                    method: "POST",
                    data: {
                      subCategoryList: catId,
                    },
                    beforeSend: function () {
                      subCategory.innerHTML =
                        '<option value="">Loading...</option>';
                    },
                    success: function (data) {
                      subCategory.innerHTML = data;
                    },
                  });
                });

                itemForm.addEventListener("submit", function (event) {
                  event.preventDefault();
                  let files = image.files;

                  // CLEAN ALL EMPTY
                  if (
                    clean(category) > 0 &&
                    clean(subCategory) &&
                    clean(itemName) > 0 &&
                    clean(qty) > 0 &&
                    clean(costPrice) > 0 &&
                    clean(sellingPrice) > 0 &&
                    files.length > 0
                  ) {
                    // CHECK IMAGE TYPE && SIZE
                    let name = files[0].name;
                    let size = files[0].size;
                    let type = files[0].type;

                    if (size > 100000) {
                      ife.innerHTML = "Image is too big Max of 100Kb";
                      ife.style.visibility = "visible";
                    } else if (
                      type.toLowerCase() === "image/jpeg" ||
                      type.toLowerCase() === "image/jpg" ||
                      type.toLowerCase() === "image/png"
                    ) {
                      //   SEND FILES TO DB

                      let category = _("category");
                      let subCategory = _("sub-category");
                      let itemName = _("item-name");
                      let qty = _("qty");
                      let costPrice = _("cost-price");
                      let sellingPrice = _("selling-price");
                      let itemForm = _("item-form");
                      let image = _("image");

                      const fd = new FormData();
                      fd.append("image", files[0]);
                      fd.append("category", category.value);
                      fd.append("subCategory", subCategory.value);
                      fd.append("itemName", itemName.value);
                      fd.append("qty", qty.value);
                      fd.append("costPrice", costPrice.value);
                      fd.append("sellingPrice", sellingPrice.value);
                      fd.append("editItemForm", "edit");
                      fd.append("itemId", id);

                      $.ajax({
                        url: "./control/action.php",
                        method: "POST",
                        processData: false,
                        contentType: false,
                        data: fd,
                        beforeSend: function () {
                          bif.innerHTML = `${loadIcon} Adding`;
                          bif.disabled = true;
                        },
                        success: function (data) {
                          ife.innerHTML = data;
                          ife.style.visibility = "visible";
                          bif.innerHTML = `Submit`;
                          bif.disabled = false;
                          if (
                            data.trim() ===
                            "<div class='text-success'>ITEM UPDATED SUCCESSFULLY</div> "
                          ) {
                            bif.disabled = true;
                          }
                        },
                      });
                    } else {
                      ife.innerHTML =
                        "Invalid file selected jpg, jpeg or png only";
                      ife.style.visibility = "visible";
                    }
                  } else {
                    ife.innerHTML = "ALL FIELD(s) REQUIRED";
                    ife.style.visibility = "visible";
                  }
                });
              });
            } else if (value === "deactivate") {
              // SEND FOR ITEM DELETE FORM
            }
          };
        });
      });
    }
  };
});
