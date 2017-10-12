<script src="include/jquery-1.3.1.min.js" type="text/javascript"></script>
<div id="display"></div>
<script type="text/javascript">
var seconds     = 1;
var refresher   = function()
{
    var data_to_send = {location: window.location};
    $('#display').load('include/time_view.php', data_to_send);
}
var refreshing  = setInterval(refresher, seconds * 1000);
</script>