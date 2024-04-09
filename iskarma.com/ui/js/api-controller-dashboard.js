function loadDashboardOverview(obj) {
	var hello = obj.content;
	$(".tab-content").load('iskarma.com/sections/dashboard/views/overview.php', function () {
		$(".hello").html(hello);
	});
}
