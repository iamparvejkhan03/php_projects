let scroll_to_top = document.querySelector(".scroll_to_top");
window.addEventListener("scroll", function(){
    if(this.window.scrollY>100){
        scroll_to_top.style.display = "block";
    }else{
        scroll_to_top.style.display = "none";
    }
})

scroll_to_top.addEventListener("click", function(){
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    })
})