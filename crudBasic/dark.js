let mode_btn = document.querySelector(".mode_btn");
let main = document.querySelector(".main");
let main_alike_with_styling = document.getElementsByClassName("main_alike_with_styling");
let form = document.querySelectorAll(".form");
let header = document.querySelector(".header");
let footer = document.getElementById("footer");
let hero_section = document.querySelector(".hero_section");
let social_icons = document.querySelectorAll(".social_icons a");
let h3 = document.querySelectorAll("h3");
let h2 = document.querySelectorAll("h2");
let h1 = document.querySelector("h1");
let a = document.querySelectorAll("a");
let p = document.querySelectorAll("p");
let input = document.querySelectorAll("input, textarea");
let input_file = document.querySelectorAll("input[type=file]");
let button = document.querySelectorAll("button");
let commentor_name_date_button = document.querySelectorAll(".commentor_name_date button");
let post_a_blog = document.getElementsByClassName("post_a_blog");
let post_a_blog_view = document.querySelector(".post_a_blog_view");
let post_a_blog_search = document.querySelector("button[name=post_a_blog_search]");
let sub_form = document.querySelectorAll(".sub_form");
let sub_form_children = document.querySelectorAll(".sub_form p, .sub_form a, .sub_form h3");
let table = document.querySelector("table");
let update_button = document.querySelector("button[name=update]");
let delete_button = document.querySelector("button[name=delete_profile]");
let search_button = document.querySelector(".search_button");
let tr_even = document.querySelectorAll("tr:nth-child(even)");
let blog_content = document.querySelector(".blog_content");
let blog_content_h1 = document.querySelector(".blog_content h1");
let blog_content_p = document.querySelector(".blog_content p");
let blog_text_p = document.querySelectorAll(".blog_text p");
let view_post_right_panel = document.querySelector(".view_post_right_panel");
console.log(commentor_name_date_button);
mode_btn.addEventListener("click", function(){
        if(main){
                main.classList.toggle("dark_background");
        }
        if(main_alike_with_styling){
                for(let i=0; i<main_alike_with_styling.length; i++){
                        main_alike_with_styling[i].classList.toggle("dark_background");
                }
        }
        if(form){
                for(let i=0; i<form.length; i++){
                        form[i].classList.toggle("light_background");
                        form[i].classList.toggle("light_box_shadow");
                }
        }
        if(header){
                header.classList.toggle("light_background");
        }
        if(footer){
                footer.classList.toggle("light_background");
        }
        // h3.classList.toggle("light_color");
        if(h2){
                for(let i=0; i<h2.length; i++){
                        h2[i].classList.toggle("light_color");
                }
        }
        if(h3){
                for(let i=0; i<h3.length; i++){
                        h3[i].classList.toggle("dark_color");
                }
        }
        if(h1){
                h1.classList.toggle("dark_color");
        }
        if(a){
                for(let i=0; i<a.length; i++){
                        a[i].classList.toggle("dark_color");
                }
        }
        if(social_icons){
                for(let i=0; i<social_icons.length; i++){
                        social_icons[i].classList.toggle("dark_color_purple");
                        social_icons[i].classList.toggle("dark_color");
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
        if(post_a_blog){
                for(let i=0; i<post_a_blog.length; i++){
                        post_a_blog[i].classList.toggle("light_background");
                        post_a_blog[i].classList.toggle("dark_color");
                }
        }

        if(sub_form){
                for(let i=0; i<sub_form.length; i++){
                        sub_form[i].classList.toggle("dark_background");
                        sub_form[i].classList.toggle("light_color");
                }
        }
        if(sub_form_children){
                for(let i=0; i<sub_form_children.length; i++){
                        sub_form_children[i].classList.toggle("light_color");
                        sub_form_children[i].classList.remove("dark_color");
                }
        }
        if(input){
                for(let i=0; i<input.length; i++){
                        input[i].classList.toggle("light_background");
                }
        }
        if(input_file){
                for(let i=0; i<input_file.length; i++){
                        input_file[i].classList.toggle("dark_background");
                        input_file[i].classList.toggle("light_background");
                }
        }
        if(hero_section){
                hero_section.classList.toggle("dark_hero_section");
        }
        if(table){
                table.classList.toggle("light_background");
        }
        if(update_button){
                update_button.classList.remove("dark_background");
        }
        if(delete_button){
                delete_button.classList.remove("dark_background");
        }
        if(search_button){
                search_button.classList.toggle("light_background");
                search_button.classList.toggle("dark_color");
                search_button.classList.remove("dark_background");
                search_button.classList.remove("light_color");
        }
        if(post_a_blog_search){
                post_a_blog_search.classList.toggle("light_background");
                post_a_blog_search.classList.toggle("dark_color");
                post_a_blog_search.classList.remove("dark_background");
                post_a_blog_search.classList.remove("light_color");
        }
        if(tr_even){
                for(let i=0; i<tr_even.length; i++){
                        tr_even[i].classList.toggle("dark_background");
                }
        }
        if(blog_content){
                blog_content.classList.toggle("dark_background");
        }
        if(blog_content_h1){
                blog_content_h1.classList.toggle("light_color");
                blog_content_h1.classList.remove("dark_color");
        }
        if(blog_text_p){
                for(let i=0; i<blog_text_p.length; i++){
                        blog_text_p[i].classList.toggle("light_color");
                        blog_text_p[i].classList.remove("dark_color");
                }
        }
        if(blog_content_p){
                blog_content_p.classList.toggle("light_color");
                blog_content_p.classList.remove("dark_color");
        }
        if(post_a_blog_view){
                post_a_blog_view.classList.toggle("light_background");
                post_a_blog_view.classList.toggle("dark_color");
                post_a_blog_view.classList.remove("dark_background");
                post_a_blog_view.classList.remove("light_color");
        }
        if(view_post_right_panel){
                view_post_right_panel.classList.toggle("dark_background");
        }
        if(commentor_name_date_button){
                for(let i=0; i<commentor_name_date_button.length; i++){
                        commentor_name_date_button[i].classList.remove("dark_background");
                        commentor_name_date_button[i].classList.remove("light_color");
                }
        }
})