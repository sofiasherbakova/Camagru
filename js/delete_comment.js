"use strict";

(function () {
    
    document.querySelectorAll(".delete").forEach(item => item.addEventListener("click", function () 
    {
        let xhttp;
        let url = "ajax/delete_comment.php";
        let param = "comment_id=" + this.id;
        xhttp = new XMLHttpRequest();
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200)
            {
                window.location.reload()
            };
        };
        xhttp.send(param);
    } , false));

})();