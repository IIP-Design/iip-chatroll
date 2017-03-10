function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function insertChatroll(){
    var title = jQuery('#chatroll_title').val();
    var height = jQuery('#chatroll_height').val();
    var width = jQuery('#chatroll_width').val();
    var id = jQuery('#chatroll_id').val();
    var name = jQuery('#chatroll_name').val();
    var domain = jQuery('#chatroll_domain').val();
    var align = jQuery('#chatroll_align').val();
    var offsetx = jQuery('#chatroll_offsetx').val();
    var offsety = jQuery('#chatroll_offsety').val();

    window.send_to_editor("[iip_chatroll title=\"" + title + "\" width=\"" + width + "\" height=\"" + height + "\" id=\"" + id + "\" name=\"" + name + "\" domain=\"" + domain + "\" align=\"" + align + "\" offsetX=\"" + offsetx + "\" offsetY=\"" + offsety + "\" ]");
}