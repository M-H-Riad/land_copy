// Navigation Highlight
function highlight_nav(open, active){
	$(".nav-item").removeClass("open");
	$(".nav-item").removeClass("active");
	$("."+open).addClass("open");
	$("."+open).addClass("active");
	$("."+active).addClass("active");
	$("."+active).addClass("open");
}

// Close Navigation
function close_nav(){
	$(".page-sidebar-menu").addClass("page-sidebar-menu-closed");
	$(".page-header-fixed").addClass("page-sidebar-closed");
}

// Open Navigation
function open_nav(){
	$(".page-sidebar-menu").removeClass("page-sidebar-menu-closed");
	$(".page-header-fixed").removeClass("page-sidebar-closed");
}