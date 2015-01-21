    <footer class="row" id="footer">
        <div class="sixteen columns">
        	<hr />
            <p>&copy; Copyright Forsyth Technical Community College, all rights reserved.</p>
        </div>
    </footer>
  </div>
  
    <script src="javascripts/vendor/jquery.js"></script>
    <script src="javascripts/jquery.datetimepicker.js"></script>
    <script src="javascripts/foundation.min.js"></script>
    <script>
        $(document).foundation();
        $('#openTime').datetimepicker({
            datepicker:false,
            format:'H:i'
        });
        $('#open').datetimepicker({
            timepicker:false,
            format:'m/d/Y'
        });
        $('#closeTime').datetimepicker({
            datepicker:false,
            format:'H:i'
        });
        $('#close').datetimepicker({
            timepicker:false,
            format:'m/d/Y'
        });
        $('#iopenTime').datetimepicker({
            datepicker:false,
            format:'H:i'
        });
        $('#iopen').datetimepicker({
            timepicker:false,
            format:'m/d/Y'
        });
        $('#icloseTime').datetimepicker({
            datepicker:false,
            format:'H:i'
        });
        $('#iclose').datetimepicker({
            timepicker:false,
            format:'m/d/Y'
        });
    </script>
</body>
</html>