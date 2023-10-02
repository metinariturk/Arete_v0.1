<script>
function addSelect() {
  var T = document.getElementById('xTable');

  var R = document.querySelectorAll('tbody .row')[0];

  var C = R.cloneNode(true);

  T.appendChild(C);

}
</script>