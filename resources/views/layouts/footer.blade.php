@guest

@else
<footer class="footer mt-auto">
  <div class="copyright bg-white">
    <p>
      &copy; <span id="copy-year">2019</span> Sistem Informasi Inventory
      <a
        class="text-primary"
        href="http://www.iamabdus.com/"
        target="_blank"
        >Toriq</a
      >.
    </p>
  </div>
  <script>
      var d = new Date();
      var year = d.getFullYear();
      document.getElementById("copy-year").innerHTML = year;
  </script>
</footer>
@endguest