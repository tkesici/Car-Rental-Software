<script>
function relocate(text) {
 location.href =text;
}

function over(id) {
 id.class = "nav-link px-2 text-secondary";
}

function out(id) {
  if (!(id.class = "nav-link px-2 text-warning")) {
     id.class = "nav-link px-2 text-white";
   }
}
function search(word) {
  word.q.value = "http://www.google.com/search/"+word;
}
</script>