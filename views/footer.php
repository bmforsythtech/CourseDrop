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
            format:'H:i',
            scrollInput:false
        });
        $('#open').datetimepicker({
            timepicker:false,
            format:'m/d/Y',
            scrollInput:false
        });
        $('#closeTime').datetimepicker({
            datepicker:false,
            format:'H:i',
            scrollInput:false
        });
        $('#close').datetimepicker({
            timepicker:false,
            format:'m/d/Y',
            scrollInput:false
        });
        $('#iopenTime').datetimepicker({
            datepicker:false,
            format:'H:i',
            scrollInput:false
        });
        $('#iopen').datetimepicker({
            timepicker:false,
            format:'m/d/Y',
            scrollInput:false
        });
        $('#icloseTime').datetimepicker({
            datepicker:false,
            format:'H:i',
            scrollInput:false
        });
        $('#iclose').datetimepicker({
            timepicker:false,
            format:'m/d/Y',
            scrollInput:false
        });
    </script>
</body>
</html>