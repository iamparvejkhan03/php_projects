//SCROLL TO TOP BUTTON
let scroll_to_top = document.querySelectorAll(".scroll_to_top");
window.addEventListener("scroll", function(){
    if(this.window.scrollY>100){
        for(let i=0; i<scroll_to_top.length; i++){
            scroll_to_top[i].style.display = "block";
        }
    }else{
        for(let i=0; i<scroll_to_top.length; i++){
            scroll_to_top[i].style.display = "none";
        }
    }
})

for(let i=0; i<scroll_to_top.length; i++){
    scroll_to_top[i].addEventListener("click", function(){
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        })
    })
}

let message_counter = document.querySelector(".message_counter");
if(message_counter.textContent == 0){
    message_counter.style.display = 'none';
}