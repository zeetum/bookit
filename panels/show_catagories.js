function button_toggle(class_name) {
    var panels = document.getElementsByClassName(class_name);

    for (var i = 0; i < panels.length; i++) {
        if (panels[i].style.display != "block")
            panels[i].style.display = "block";
	else
            panels[i].style.display = "none";
    }
}
