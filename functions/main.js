function toggle_class_display(class_name) {
    var panels = document.getElementsByClassName(class_name);

    for (var i = 0; i < panels.length; i++) {
        if (panels[i].style.display === "block") {
            panels[i].style.display = "none";
            panels[i].style.background = "#08c";
	} else {
            panels[i].style.display = "block";
            panels[i].style.background = "blue";
	}
    }
}
function hide_class_display(class_name) {
    var panels = document.getElementsByClassName(class_name);

    for (var i = 0; i < panels.length; i++) {
        var sibling = panels[i].previousSibling;
        sibling.style.background = "#08c";
        panels[i].style.display = "none";
    }
}

function show_id_display(id_name) {
    var panel = document.getElementById(id_name);
    var sibling = panel.previousElementSibling;
    panel.style.display = "block";
    sibling.style.background = "blue";
}

function hide_id_display(id_name) {
    var panel = document.getElementById(id_name);
    panel.style.display = "none";
}

