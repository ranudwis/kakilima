$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: function(jqxhr){
        notifError(jqxhr.responseJSON.message);
    }
});
$(window).scroll(function(){
    if($(this).scrollTop() == 0){
        $("#navbar").removeClass("scroll");
        $("#scrollToTop").addClass("hide");
        // $("#categorySection").css("display","none");
    }else{
        $("#navbar").addClass("scroll");
        $("#scrollToTop").removeClass("hide");
        // $("#categorySection").css("display","inline-flex");
    }
});
$("#scrollToTop").click(function(){
    $("body").animate({
        scrollTop: 0
    },"slow");
});
$("#content").click(function(){
    $(".dropdownSection.visible").each(function(){
        $(this).removeClass("visible");
    });
});
$(".dropdownSection > a:first-child").click(function(event){
    event.preventDefault();
    var now = $(this).parent();
    var check = false;
    if(now.hasClass("visible")){
        now.removeClass("visible");
    }else{
        $(".dropdownSection.visible").each(function(){
            $(this).removeClass("visible");
        })
        now.addClass("visible");
    }
    // if(now.hasClass("visisble") == false){
    //     check = true;
    //     now.addClass("visible");
    // }
    // $(".dropdownSection.visible").each(function(index,element){
    //     if(now[0] != element || ($(element).hasClass("visible") && !check)){
    //         $(this).removeClass("visible");
    //     }
    // });
});
$("#dashboardNavigator span").click(function(){
    $(this).toggleClass("active");
    $(this).next().slideToggle(400);
});
// $(".largeImageUpload").click(function(){
//     $("#imageUpload").click();
// })
$(".addImageUpload").click(function(){
    var clone = $(this).prev().clone();
    $(this).before(clone);
    clone.children("input").first().val("");
})
$(".addToFav").click(function(){
    $.post(basepath+"/addfavorites",{item: $(this).parent().attr("id")},function(data){
        if(data){
            notifSuccess("Added to favorites");
        }else{
            notifSuccess("Removed from favorites");
        }
    });
});
var notification = document.getElementById("notification");
var formlabels = document.getElementsByClassName("formlabel");
if(typeof errors != "undefined"){
    var form = document.querySelector(".form") || document.querySelector(".regularform");
    for(i in errors){
        var element = form[i];
        element.classList.add("error");
        element.addEventListener("input",function(){
            this.classList.remove("error");
            var next = this.parentElement.nextElementSibling;
            this.parentElement.parentElement.removeChild(next);
        });

        var div = document.createElement("div");
        div.innerHTML = "<i class=\"fa fa-warning fa-fw\"></i><span>"+errors[i]+"</span>";
        div.addEventListener("mouseenter",function(){
            this.lastElementChild.style.display = "block";
            setTimeout(function(element){element.classList.add("active")},100,this);
        })
        div.addEventListener("mouseleave",function(){
            this.classList.remove("active");
            setTimeout(function(element){element.lastElementChild.style.display = "none"},200,this);
        })
        div.className = "formError"
        element.parentElement.parentElement.appendChild(div);
    }
}
function notifSuccess(text){
    notification.innerHTML = "<i class=\"fa fa-info-circle fa-fw\"></i>"+text;
    notification.className = "notify"
    showNotif();
}
function notifError(text){
    notification.innerHTML = "<i class=\"fa fa-warning fa-fw\"></i>"+text;
    notification.className = "error";
    showNotif();
}
function showNotif(){
    notification.onclick = function(){
        notification.classList.add("hide");
    }

    setTimeout(function(){
        if(!notification.classList.contains('hide')){
            notification.classList.add("hide");
        }
    },10000);
}
if(notification != null && notification.classList.contains("notify") || notification.classList.contains("error")){
    setTimeout(function(){
        notification.classList.remove("hide");
    },100);
    notification.onclick = function(){
        notification.classList.add("hide");
    }

    setTimeout(function(){
        if(!notification.classList.contains('hide')){
            notification.classList.add("hide");
        }
    },10000);
}

function inputFocus(){
    if(this.tagName == "INPUT"){
        this.parentElement.previousElementSibling.style.top = "0";
        this.parentElement.previousElementSibling.style.color = "#616161";
    }else{
        this.nextElementSibling.firstElementChild.focus();
    }
}
function inputBlur(){
    if(this.value == ""){
        this.parentElement.previousElementSibling.style.top = this.parentElement.parentElement.clientHeight/2+"px";
        this.parentElement.previousElementSibling.style.color = "#9e9e9e";
    }
}
if(formlabels.length != 0){
    for(var i=0;i<formlabels.length;i++){
        if(formlabels[i].nextElementSibling.firstElementChild.autofocus == false){
            formlabels[i].style.top = formlabels[i].parentElement.clientHeight/2+"px";
            formlabels[i].style.color = "#9e9e9e";
        }
        if(formlabels[i].nextElementSibling.firstElementChild.value != ""){
            formlabels[i].style.top = 0;
        }
        formlabels[i].addEventListener("click", inputFocus);
        formlabels[i].nextElementSibling.firstElementChild.addEventListener("focus",inputFocus);
        formlabels[i].nextElementSibling.firstElementChild.addEventListener("blur",inputBlur);
    }
}
