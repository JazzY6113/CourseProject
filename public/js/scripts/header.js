document.addEventListener("DOMContentLoaded", function (){
    document.querySelector(".burger").onclick = function (){
        document.querySelector(".navBurger").classList.contains("active") ?
            document.querySelector(".navBurger").classList.remove("active"):
            document.querySelector(".navBurger").classList.add("active");
    }
});
