/**
 * Created by niko on 24/08/14.
 */

window.onload = function () {
    document.getElementById("body").addEventListener('input', function() {
        document.getElementById("message").innerHTML = "Unsaved Changes!";
    }, false);
    document.getElementById("del").addEventListener('click', function() {
        if (confirm("Are You Sure?")) {
            var form = document.getElementById("editform");
            form.delconf.value = "confirm";
            form.submit();
        }
    }, false);
}