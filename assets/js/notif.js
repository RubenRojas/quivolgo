$(document).ready(function(){
	$(".notificacion").addClass("show");
	setTimeout(function(){ $(".notificacion").removeClass("show"); }, 4000);
	$(".notificacion").on('click', function(){
		$(this).removeClass("show");
	});
});

function notif_close(){
	$(".notificacion").removeClass("show");
}