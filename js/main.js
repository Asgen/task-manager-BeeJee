const checkboxes = document.querySelectorAll('.custom-control-input');
const saveButtons = document.querySelectorAll('.save-button');

checkboxes.forEach((checkbox) => {
  checkbox.addEventListener('change', (evt) => {
    let status = evt.target.checked ? 0 : 1;
    let strGET = window.location.search.replace( '?', '');
    document.location.href = "/edit/status/?id=" + evt.target.id + '&status=' + status + '&' + strGET;
  })
})
