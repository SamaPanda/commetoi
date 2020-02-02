/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/global.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {

    const storage = window.sessionStorage;
    const countCart = function (){
        var c = 0;
        $.each(JSON.parse(storage.getItem("cart")),function(i,v) { console.log(v); c = c+v})
        $('#cart-count').html(c)
    }

    const emptyCart = function(){
        storage.removeItem("cart");
        countCart();
    }


    $('.carts').click(function() {
        let cart = storage.getItem("cart") ? JSON.parse(storage.getItem("cart")) : {} ;
        const itemId = $(this).data("id");
        const quantity = $('#quantity').length > 0 ? parseInt($('#quantity').val()) : 1 ;
        cart[itemId] = cart[itemId] ? cart[itemId] + quantity: quantity;
        storage.setItem("cart",JSON.stringify(cart))
        countCart();
    })

    countCart();

    var quantitiy=0;
    $('.plus').click(function(e){
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        $('#quantity').val(quantity + 1);
    });

    $('.minus').click(function(e){
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        if(quantity>1){
            $('#quantity').val(quantity - 1);
        }
    });


});

