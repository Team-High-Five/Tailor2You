const items = document.querySelectorAll(".category .item");
items.forEach((item) => {
    item.addEventListener("click", () => {
       removeActiveClasses();
        item.classList.add("active");
    });
 });
function removeActiveClasses() {
     items.forEach((item) => {
         item.classList.remove("active");
    });
}