
  function filterContacts() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("input-search");
    filter = input.value.toLowerCase();
    table = document.getElementById("user-table");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
      tr[i].style.display = "none";
      td = tr[i].getElementsByTagName("td");
      for (var j = 0; j < td.length; j++) {
        if (td[j]) {
          txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toLowerCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
            break;
          }
        }
      }
    }
  }
