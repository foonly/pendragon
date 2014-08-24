/**
 * Created by niko on 24/08/14.
 */

window.onload = function () {
    document.getElementById("body").addEventListener('input', function() {
        document.getElementById("message").innerHTML = "Unsaved Changes!";
        document.getElementById("tab").removeEventListener('change',submitSelector);
        document.getElementById("tab").addEventListener('change',returnSelector);
    });
    document.getElementById("del").addEventListener('click', function() {
        if (confirm("Are You Sure?")) {
            var form = document.getElementById("editform");
            form.delconf.value = "confirm";
            form.submit();
        }
    });
    document.getElementById("tab").addEventListener('change',submitSelector);
}

function submitSelector() {
    document.getElementById("selector").submit();
}
function returnSelector() {
    if (confirm("Discard Changes?")) {
        document.getElementById("selector").submit();
    }
    document.getElementById("tab").value = document.getElementById("oldtab").value;
}