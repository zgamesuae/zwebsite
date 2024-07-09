parent = $(".rating.rate-action")

function fill_star(star){
    position = $(".star").index(star)

    parent.children(".star").each((index,element)=>{
        if(index <= position){
            $(element).addClass("star-filled")
        }

        else{
            $(element).removeClass("star-filled")
        }

    })
}

function fixed_fill(star){
    position = $(".star").index(star)

    parent.children(".star").each((index,element)=>{
        if(index <= position){
            $(element).addClass("star-filled-fixed")
        }

        else{
            $(element).removeClass("star-filled-fixed")
        }
    })

   

}

function umpty_star(){
    $(".rating.rate-action .star-filled").removeClass("star-filled")
}


$(".rating.rate-action .star").mouseover(function(){
    fill_star($(this))

})

$(".rating.rate-action .star").mouseout(function(){
    umpty_star()
})

$(".rating.rate-action .star").click(function(){
    rating= $("form .rating-group input[name='rating']")
    rating.val(($(".star").index($(this))+1))
    fixed_fill($(this))

})

// $("form#rating-form").submit(function(event){
//     event.preventDefault()
// })

// $("form#rating-form button[type='submit']").click(function(){
//     data = {}

//     form = $("form#rating-form")

// })





