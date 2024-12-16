let mode_btn = document.querySelector(".mode_btn");
let main = document.querySelector(".main");
let form = document.querySelector(".form");
let header = document.querySelector(".header");
let h3 = document.querySelector("h3");
let h2 = document.querySelector("h2");
let h1 = document.querySelector("h1");
let a = document.querySelectorAll("a");
let p = document.querySelectorAll("p");
let input = document.querySelectorAll("input");
let button = document.querySelectorAll("button");
mode_btn.addEventListener("click", function(){
        if(main){
                main.classList.toggle("dark_background");
        }
        if(form){
                form.classList.toggle("light_background");
                form.classList.toggle("light_box_shadow");
        }
        if(header){
                header.classList.toggle("light_background");
        }
        // h3.classList.toggle("light_color");
        if(h2){
                h2.classList.toggle("dark_color");
        }
        if(h3){
                h3.classList.toggle("dark_color");
        }
        if(h1){
                h1.classList.toggle("dark_color");
        }
        if(a){
                for(let i=0; i<a.length; i++){
                        a[i].classList.toggle("dark_color");
                }
        }
        if(p){
                for(let i=0; i<p.length; i++){
                        p[i].classList.toggle("dark_color");
                }
        }
        if(button){
                for(let i=0; i<button.length; i++){
                        button[i].classList.toggle("dark_background");
                        button[i].classList.toggle("light_color");
                }
        }
        if(input){
                for(let i=0; i<input.length; i++){
                        input[i].classList.toggle("light_background");
                }
        }
        console.log(input);
})