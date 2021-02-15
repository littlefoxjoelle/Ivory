$(document).ready(function(){

$("#select-sort").click(function(){
    $(".sorting-list").slideToggle(300);
});



$('#button-pass-show-hide').click(function() {
    var statuspass =$('#button-pass-show-hide').attr("class");
    
    if(statuspass == "pass-show") {
        $('#button-pass-show-hide').attr("class","pass-hide");
            var $input = $("#auth_pass");
            var change ="text";
            var rep = $("<input type='" + change + "' />")
                .attr("id",$input.attr("id"))
                .attr("name",$input.attr("name"))
                .attr('class',$input.attr('class'))
                .val($input.val())
                .insertBefore($input);
            $input.remove();
            $input = rep;
    } else {
        $('#button-pass-show-hide').attr("class","pass-show");
            var $input = $("#auth_pass");
            var change ="password";
            var rep = $("<input type='" + change + "' />")
                .attr("id",$input.attr("id"))
                .attr("name",$input.attr("name"))
                .attr('class',$input.attr('class'))
                .val($input.val())
                .insertBefore($input);
            $input.remove();
            $input = rep;
    }
});

$('#confirm-button-next').click(function(e){
    var order_f = $("#order_f").val();
    var order_i = $("#order_i").val();
    var order_o = $("#order_o").val();
    var order_email = $("#order_email").val();
    var order_phone = $("#order_phone").val();
    var order_adress = $("#order_adress").val();
    
    if (!$(".order_delivery").is(":checked"))
    {
        $(".label_delivery").css("color", "rgb(212, 57, 57)");
        send_order_delivery = '0';
    }
    else{
        $(".label_delivery").css("color", "#614a5f");
        send_order_delivery = '1';
    }

    if (order_f == "" || order_f.length > 25)
    {
        $("#order_f").css("borderColor", "rgb(212, 57, 57)");
        send_order_f = '0';
    }
    else{
        $("#order_f").css("border-left:", "1px solid #775c75", "border-top:", "1px solid #775c75", "border-right:", "1px solid #a88aa6", "border-bottom:", "1px solid #a88aa6");
        send_order_f = '1'; 
    }

    if (order_i == "" || order_i.length > 25)
    {
        $("#order_i").css("borderColor", "rgb(212, 57, 57)");
        send_order_i = '0';
    }
    else{
        $("#order_i").css("border-left:", "1px solid #775c75", "border-top:", "1px solid #775c75", "border-right:", "1px solid #a88aa6", "border-bottom:", "1px solid #a88aa6");
        send_order_i = '1'; 
    }

    if (order_o == "" || order_o.length > 25)
    {
        $("#order_o").css("borderColor", "rgb(212, 57, 57)");
        send_order_o = '0';
    }
    else{
        $("#order_o").css("border-left:", "1px solid #775c75", "border-top:", "1px solid #775c75", "border-right:", "1px solid #a88aa6", "border-bottom:", "1px solid #a88aa6");
        send_order_o = '1'; 
    }

    if (order_email == "" || order_email.length > 25)
    {
        $("#order_email").css("borderColor", "rgb(212, 57, 57)");
        send_order_email = '0';
    }
    else{
        $("#order_email").css("border-left:", "1px solid #775c75", "border-top:", "1px solid #775c75", "border-right:", "1px solid #a88aa6", "border-bottom:", "1px solid #a88aa6");
        send_order_email = '1'; 
    }

    if (order_phone == "")
    {
        $("#order_phone").css("borderColor", "rgb(212, 57, 57)");
        send_order_phone = '0';
    }
    else{
        $("#order_phone").css("border-left:", "1px solid #775c75", "border-top:", "1px solid #775c75", "border-right:", "1px solid #a88aa6", "border-bottom:", "1px solid #a88aa6");
        send_order_phone = '1'; 
    }

    if (order_adress == "" || order_adress.length > 25)
    {
        $("#order_adress").css("borderColor", "rgb(212, 57, 57)");
        send_order_adress = '0';
    }
    else{
        $("#order_adress").css("border-left:", "1px solid #775c75", "border-top:", "1px solid #775c75", "border-right:", "1px solid #a88aa6", "border-bottom:", "1px solid #a88aa6");
        send_order_adress = '1'; 
    }

    if (send_order_delivery == "1" && send_order_f == "1" && send_order_i=="1" && send_order_o=="1" && send_order_email=="1" && send_order_phone=="1" && send_order_adress=="1"){
        return true;
    }
    e.preventDefault();

});


$('.add-cart-style-list').click(function(){
var tid = $(this).attr("tid");
console.log('add');
$.ajax({
    type: "POST",
    url: "addtocart.php",
    data: "action=add&id="+tid,
    dataType: "html",
    cache: false,
    success: function(data){
    alert('Товар добавлен в корзину!');
    }


});
});


$('.count-minis').click(function(){
var iid = $(this).attr("iid");

$.ajax({
    type: "POST",
    url: "count-minus.php",
    data: "id="+iid,
    dataType: "html",
    cache: false,
    success: function(data){
        $("#input-id"+iid).val(data);

        var priceproduct = $("#tovar"+iid +" > p").attr("price");
        result_total = Number(priceproduct) * Number(data);

        $("#tovar"+iid +" > p").html(result_total)+" руб";
        $("#tovar"+iid +" > h5 > .span-count").html(data);
        itog_price();
    }
});

});

$('.count-plus').click(function(){
    var iid = $(this).attr("iid");
    
    $.ajax({
        type: "POST",
        url: "count-plus.php",
        data: "id="+iid,
        dataType: "html",
        cache: false,
        success: function(data){
            $("#input-id"+iid).val(data);
    
            var priceproduct = $("#tovar"+iid +" > p").attr("price");
            result_total = Number(priceproduct) * Number(data);
    
            $("#tovar"+iid +" > p").html(result_total)+" руб";
            $("#tovar"+iid +" > h5 > .span-count").html(data);
            itog_price();
        }
    });
});

$('.count-input').keypress(function(e){

    if (e.keyCode==13){
    var iid = $(this).attr("iid");
    var incount = $("#input-id"+iid).val();
    
    $.ajax({
        type: "POST",
        url: "count-input.php",
        data: "id="+iid+"&count="+incount,
        dataType: "html",
        cache: false,
        success: function(data){
            $("#input-id"+iid).val(data);
    
            var priceproduct = $("#tovar"+iid +" > p").attr("price");
            result_total = Number(priceproduct) * Number(data);
    
            $("#tovar"+iid +" > p").html(result_total)+" руб";
            $("#tovar"+iid +" > h5 > .span-count").html(data);
            itog_price();
        }
    });
}
});

function itog_price(){
    $.ajax({
        type: "POST",
        url: "itog_price.php",
        dataType: "html",
        cache: false,
        success: function(data){
            $ (".itog-price > strong").html(data);
        }
    }); 
} 
});

