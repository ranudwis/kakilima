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
$("body").click(function(){
    $(".dropdownSection.visible").each(function(){
        $(this).removeClass("visible");
    });
});
$(".dropdownSection > a:first-child").click(function(event){
    event.stopPropagation();
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
var starClick = 0;
$(".starsButton label").hover(function(){
    $(".starsButton label i").addClass("fa-star-o").removeClass("fa-star yellow");
    $(this).children().removeClass("fa-star-o").addClass("fa-star yellow");
    var prev = $(this).prevAll("label").children().removeClass("fa-star-o").addClass("fa-star yellow");
},function(){
    if(starClick == 0){
        $(".starsButton label i").addClass("fa-star-o").removeClass("fa-star yellow");
    }else{
        var stars = $(".starsButton label i").addClass("fa-star-o").removeClass("fa-star yellow");
        for(var i = 0; i < starClick; i++){
            $(stars[i]).removeClass("fa-star-o").addClass("fa-star yellow");
        }
    }
});
$(".starsButton label").click(function(){
    starClick = $(this).prev().val();
});
var waitClick = false;
var slideClick = false;
if($("#slider").length != 0){
    setInterval(function(){
        if(slideClick){
            slideClick=false;
            return;
        }
        if(waitClick){
            return;
        }
        waitClick = true;
        var active = $("#slider img.active");
        var next = active.next("img");
        if(next.length == 0){
            next = $("#slider img:first-child");
            next.addClass("active");
            active.removeClass("active");
            $("#slider img.left").removeClass("left");
        }else{
            active.addClass("left");
            next.addClass("active");
            active.removeClass("active");
        }
        setTimeout(function(){waitClick=false},1000);
    },5000);
}
$("#slider .control-right").click(function(){
    if(waitClick){
        return;
    }
    waitClick = true;
    slideClick = true;
    var active = $("#slider img.active");
    var next = active.next("img");
    if(next.length == 0){
        next = $("#slider img:first-child");
        next.addClass("active");
        active.removeClass("active");
        $("#slider img.left").removeClass("left");
    }else{
        active.addClass("left");
        next.addClass("active");
        active.removeClass("active");
    }
    setTimeout(function(){waitClick=false},1000);
})
$("#slider .control-left").click(function(){
    if(waitClick){
        return;
    }
    waitClick = true;
    slideClick = true;
    var active = $("#slider img.active");
    var next = active.prev("img");
    if(next.length == 0){
        next = $("#slider img:last-of-type");
        next.addClass("active");
        active.removeClass("active");
        $("#slider img:not(.active)").addClass("left");
    }else{
        next.addClass("active");
        next.removeClass("left");
        active.removeClass("active");
    }
    setTimeout(function(){waitClick=false},1000);
})
$(".imageViewer .otherImages img").click(function(){
    $(".imageViewer .mainImage img").attr("src",$(this).attr("src"));
})
$(".productButton .decCartCount").click(function(){
    var now = parseInt($(this).next().val());
    if(isNaN(now)){
        var next = 1;
    }else if(now <= 1){
        next = 1;
    }else if(now >= $(this).next().attr("max")){
        next = $(this).next().attr("max");
    }else{
        var next = now - 1;
    }
    $(this).next().val(next);
})
$(".productButton .incCartCount").click(function(){
    var now = parseInt($(this).prev().val());
    if(isNaN(now)){
        var next = 1;
    }else if(now >= $(this).prev().attr("max")){
        next = $(this).prev().attr("max");
    }else if(now < 1){
        next = 1;
    }else{
        var next = now + 1;
    }
    $(this).prev().val(next);
})
$('select[name=category]').change(function(){
    $(this).parent().parent().parent().submit();
});
$('select[name=condition]').change(function(){
    $(this).parent().parent().parent().submit();
});
function addCart(){
    var count = $(".btnCart").prev().children('input').val();
    if(isNaN(count)){
        count = 1;
    }
    var target = $(".btnCart").attr("href") + "/" + count;
    window.location = target;
    return false;
}
function preSend(){
    $(".receiptForm").css('display','block');
    $(".receiptForm input[name=receiptNumber]").focus();
    return false;
}
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
