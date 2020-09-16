"use strict";

(function () {
    let ur = new URL(window.location.href);
    let like = document.getElementById("like");
    let counter_likes = document.getElementById("counter_likes");

    function changeLike() {
        let xhttp;
        let url = "ajax/like.php";
        let imgId = ur.searchParams.get("image_id");
        let param = "like=set" + "&image_id=" + imgId;

        xhttp = new XMLHttpRequest();
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let json = JSON.parse(this.responseText);
                if (json.isLiked)
                    like.setAttribute('src', 'img/like_fill.png');
                else
                    like.setAttribute('src', 'img/like.png');
                counter_likes.innerHTML = json.likes;
            };
        };
        xhttp.send(param);
    }

    function getLikes() {
        let xhttp;
        let url = "ajax/like.php";
        let imgId = ur.searchParams.get("image_id");
        let param = "like=get" + "&image_id=" + imgId;

        xhttp = new XMLHttpRequest();
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let json = JSON.parse(this.responseText);
                if (json.isLiked)
                    like.setAttribute('src', 'img/like_fill.png');
                else
                    like.setAttribute('src', 'img/like.png');
                counter_likes.innerHTML = json.likes;
            };
        };
        xhttp.send(param);
    }
    window.addEventListener("load", getLikes, false);
    like.addEventListener("click", changeLike, false);
})();