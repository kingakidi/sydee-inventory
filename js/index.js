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
    });
  } else {
    showSearch.innerHTML = "";
  }
};
